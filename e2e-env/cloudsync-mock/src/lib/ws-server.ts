import {WebSocketServer} from 'ws';
import {Request} from "express";

/**
 * Websocket server used by [mock-probe.ts] to wait for and inspect requests during testing.
 */
export class WsServer {
  private server: WebSocketServer;

  constructor(port: number) {
    this.server = new WebSocketServer({port});

    this.server.on('error', err => {
      console.error(err);
    })

    console.log(`Probe listening on port \x1b[96m${port}\x1b[0m`);
  }

  /**
   * send data to all connected clients
   * @param apiName
   * @param request
   */
  public sendDataToWS(apiName: string, request: Request) {
    const data = {
      apiName,
      method: request.method,
      headers: request.headers,
      url: request.url,
      query: request.query,
      params: request.params,
      body: request.body ?? {},
    };

    // there may be no client if we're not runing an automated test suite
    if (this.server.clients.size > 0) {
      this.server.clients.forEach((client) => {
        client.send(JSON.stringify(data));
      })
    }
  }
}
