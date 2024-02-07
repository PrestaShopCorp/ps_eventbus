import WebSocket, { WebSocketServer } from 'ws';
import { Request } from "express";

export class WsServer {
    private static instance: WsServer;
    private static server: WebSocketServer;
    private static client: WebSocket|null;

    private constructor() { }

    public static getInstance(): WsServer {
        if (!WsServer.instance) {
            WsServer.instance = new WsServer();

            WsServer.server = new WebSocketServer({ port: 8080 });

            WsServer.server.on('connection', (ws: WebSocket) => {
                if (WsServer.server.clients.size > 1) {
                    throw new Error('Too many connection to websocket server !');
                }
                WsServer.client = ws;
            });
            WsServer.server.on('error', err => { throw err } )

            console.log(`WS server started on port \x1b[96m8080\x1b[0m`);
        }

        return WsServer.instance;
    }

    public sendDataToWS(apiName: string, request: Request) {
        if (!WsServer.client) return;
        
        const data = {
            apiName,
            method: request.method,
            headers: request.headers,
            url: request.url,
            query: request.query,
            body: request.body ?? {},
        };

        // there may be no client if we're not runing an automated test suite
        if( WsServer.client ) {
          WsServer.client.send(JSON.stringify(data));
        }
    }
}
