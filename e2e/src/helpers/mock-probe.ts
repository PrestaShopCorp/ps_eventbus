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

const DEFAULT_OPTIONS = {
  timeout: 1500
};

export type MockProbeOptions = typeof DEFAULT_OPTIONS;
export type MockClientOptions = typeof DEFAULT_OPTIONS;

// no Websocket implementation seems to exist in jest runner
if (!global.WebSocket) {
  (global as any).WebSocket = WebSocket;
}

let wsConnection: WebSocketSubject<MockProbeResponse> = null
function getProbeSocket() {
  if (!wsConnection) {
    wsConnection = new WebSocketSubject<MockProbeResponse>('ws://localhost:8080');
  }
  return wsConnection
}

export type MockProbeResponse = {
  apiName: string,
  method: string,
  headers: Record<string, string>,
  url: string,
  query: Record<string, string>,
  params: Record<string, string>,
  body: Record<string, any> & { file: any[] }
}

export function probe(match?: Partial<MockProbeResponse>, options?: MockProbeOptions): Observable<MockProbeResponse> {
  options = R.mergeLeft(options, DEFAULT_OPTIONS);

  const socket = getProbeSocket();
  const messages$: Observable<MockProbeResponse> = socket.pipe(
    filter(message => {
      if (match) {
        return (R.whereEq(match, message));
      }
      // no filtering
      return true;
    }),
    timeout(options.timeout),
  )
  return messages$;
}

export type PsEventbusSyncResponse = {
  job_id: string,
  object_type: string,
  syncType: string, // 'full' | 'incremental'
  total_objects: number, // may not always be accurate, can't be relied on
  has_remaining_objects: boolean, // reliable
  remaining_objects: number, // may not always be accurate, can't be relied on
  md5: string,
  status: boolean,
  httpCode: number,
  body: unknown, // not sure what this is
  upload_url: string,
}

// TODO define collection as type literal
export type Collection = string

export type PsEventbusSyncUpload = {
  collection: Collection, id: string
}[]

export type Controller = typeof testConfig.controllers[number];

export function doFullSync(jobId: string, controller: Controller, options?: MockClientOptions): Observable<PsEventbusSyncResponse> {
  options = R.mergeLeft(options, DEFAULT_OPTIONS);
  const url = (full: number, jobId: string) => `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=${full}&job_id=${jobId}`;

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
    timeout(options.timeout),
    map(response => response.data)
  )
}
