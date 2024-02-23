import WebSocket from 'ws';
import {WebSocketSubject} from "rxjs/webSocket";
import {
  bufferCount,
  catchError, EMPTY,
  expand,
  filter,
  from,
  lastValueFrom,
  map,
  Observable, retry,
  Subject,
  take,
  tap,
  timeout
} from "rxjs";
import R from 'ramda';
import testConfig from "./test.config";
import axios from "axios";
import {PsEventbusSyncResponse} from "../full-sync-categories.spec";

const DEFAULT_OPTIONS = {
  timeout : 1500
};

export type MockProbeOptions = typeof DEFAULT_OPTIONS;

// no Websocket implementation seems to exist in jest runner
if (!global.WebSocket) {
  (global as any).WebSocket = WebSocket;
}

type MockProbeResponse = {
  apiName: string,
  method: string,
  headers: Record<string, string>,
  url: string,
  query: Record<string, string>,
  params: Record<string, string>,
  body: Record<string, any>
}

export class MockProbe {
  private static wsConnection: WebSocketSubject<MockProbeResponse>;
  private options : MockProbeOptions

  constructor(options?: MockProbeOptions) {
    if (!MockProbe.wsConnection) {
      MockProbe.wsConnection = new WebSocketSubject<MockProbeResponse>('ws://localhost:8080');
    }
    this.options = R.mergeLeft(options, DEFAULT_OPTIONS);
  }

  /**
   * connect the probe to the server.
   * @param expectedMessageCount how may messages to wait for before resolving
   * @param match filter only messages matching this object
   */
  public async waitForMessages(expectedMessageCount = 1, match?: Partial<MockProbeResponse>): Promise<MockProbeResponse[]> {
    const $messages: Observable<MockProbeResponse[]> = MockProbe.wsConnection.pipe(
      filter(message => {
        if (match) {
          return (R.whereEq(match, message));
        }
        // no filtering
        return true;
      }),
      bufferCount(expectedMessageCount),
      take(1),
      timeout(this.options.timeout),
    )

    return lastValueFrom($messages)
  }
}

export function doFullSync(jobId : string): Observable<PsEventbusSyncResponse> {
  const url = (full: number, jobId : string) => `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiCategories&limit=5&full=${full}&job_id=${jobId}`;

  return from(axios.post<PsEventbusSyncResponse>(url(1, jobId), {
    headers: {
      'Host': testConfig.prestaShopHostHeader
    },
  })).pipe(
    expand(response => {
      if(response.data.has_remaining_objects) {
        return from(axios.post<PsEventbusSyncResponse>(url(0, jobId), {
          headers: {
            'Host': testConfig.prestaShopHostHeader
          },
        }));
      } else {
        return EMPTY
      }
    }),
    timeout(1500),
    map(response => response.data)
  )
}
