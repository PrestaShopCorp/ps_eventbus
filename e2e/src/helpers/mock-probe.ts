import WebSocket, { RawData } from 'ws';
import {webSocket, WebSocketSubject} from "rxjs/webSocket";
import {bufferCount, catchError, filter, lastValueFrom, map, Observable, take, tap, timeout} from "rxjs";

(global as any).WebSocket = WebSocket;

type MockProbeResponse = {
  method: string,
  headers: Record<string, string>,
  url: string,
  query: Record<string, string>,
  body: Record<string, any>
}

export class MockProbe {
  private static wsConnection: WebSocketSubject<MockProbeResponse>;

  constructor() {
    if(!MockProbe.wsConnection) {
      MockProbe.wsConnection = new WebSocketSubject<MockProbeResponse>('ws://localhost:8080');
    }
  }

  /**
   * connect the probe to the server.
   * @param expectedMessageCount how may messages to wait for before resolving
   * @param jobId filter only messages with the specified jobId
   */
  public async waitForMessages(expectedMessageCount = 1, jobId = null): Promise<MockProbeResponse[]> {
    const $messages = MockProbe.wsConnection.pipe(
      tap(console.log),
      filter(message => {
        if(jobId) {
          // filter messages using jobId queryParam
          return (message.query['job_id'] === jobId);
        }
        // no filtering
        return true;
      }),
      bufferCount(expectedMessageCount),
      take(1),
      timeout(5000),
    )

    return lastValueFrom($messages)
  }
}
