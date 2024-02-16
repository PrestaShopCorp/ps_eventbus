import WebSocket from 'ws';
import { WebSocketSubject} from "rxjs/webSocket";
import {bufferCount, catchError, filter, lastValueFrom, map, Observable, take, tap, timeout} from "rxjs";
import R from 'ramda';

const PROBE_TIMEOUT=1000;

// no Websocket implementation seems to exist in jest runner
if(!global.WebSocket) {
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

  constructor() {
    if (!MockProbe.wsConnection) {
      MockProbe.wsConnection = new WebSocketSubject<MockProbeResponse>('ws://localhost:8080');
    }
  }

  /**
   * connect the probe to the server.
   * @param expectedMessageCount how may messages to wait for before resolving
   * @param match filter only messages matching this object
   */
  public async waitForMessages(expectedMessageCount = 1, match?: Partial<MockProbeResponse>): Promise<MockProbeResponse[]> {
    const $messages = MockProbe.wsConnection.pipe(
      tap(console.log),
      filter(message => {
        if (match) {
          return (R.whereEq(match, message));
        }
        // no filtering
        return true;
      }),
      bufferCount(expectedMessageCount),
      take(1),
      timeout(PROBE_TIMEOUT),
    )

    return lastValueFrom($messages)
  }
}
