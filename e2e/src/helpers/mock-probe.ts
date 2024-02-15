import {webSocket, WebSocketSubject} from "rxjs/webSocket";
import {bufferCount, filter, lastValueFrom, map, Observable, take, timeout} from "rxjs";

type MockProbeResponse = {
  method: string,
  headers: Record<string, string>,
  url: string,
  query: Record<string, string>,
  body: Record<string, any>
}

export class MockProbe {
  private static wsConnection: WebSocketSubject<string>;
  private $messages: Observable<MockProbeResponse>

  /**
   * connect the probe to the server.
   * @param jobId filter only messages with the specified jobId
   */
  public connect(jobId = null) {
    if(!MockProbe.wsConnection) {
      MockProbe.wsConnection = new WebSocketSubject<string>('ws://localhost:8080');
    }

    this.$messages = MockProbe.wsConnection.pipe(
      map(message => JSON.parse(message.toString()) as MockProbeResponse),
      filter(message => {
        if(jobId) {
          // filter messages using jobId queryParam
          return (message.query['job_id'] === jobId);
        }
        // no filtering
        return true;
      })
    )
  }

  public async waitForMessages(expectedMessageCount = 1): Promise<Array<MockProbeResponse>> {
    return lastValueFrom(this.$messages.pipe(
      bufferCount(expectedMessageCount),
      take(1),
      timeout(5000),
    ))
  }
}
