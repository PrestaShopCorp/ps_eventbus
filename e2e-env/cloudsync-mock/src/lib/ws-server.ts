import WebSocket, { WebSocketServer } from 'ws';
import { Request } from "express";

export class WsServer {
    private static instance: WsServer;
    private static server: WebSocketServer;
    private static clientList: Array<WebSocket> = new Array<WebSocket>();

    private constructor() { }

    public static getInstance(): WsServer {
        if (!WsServer.instance) {
            WsServer.instance = new WsServer();

            WsServer.server = new WebSocketServer({ port: 8080 });

            WsServer.server.on('connection', (ws: WebSocket) => {
                WsServer.clientList.push(ws);
            });

            WsServer.server.on('close', (ws: WebSocket) => {
                WsServer.clientList = WsServer.clientList.filter((client) => client !== ws);
            });

            console.log(`WS server started on port \x1b[96m8080\x1b[0m`);
        }

        return WsServer.instance;
    }

    public sendDataToWS(apiName: string, request: Request) {
        console.log(`data received from ${apiName}`);
        const data = {
            apiName,
            method: request.method,
            headers: request.headers,
            url: request.url,
            query: request.query,
            body: request.body
        };

        WsServer.clientList.forEach((ws) => {
            ws.send(JSON.stringify(data));
        });
    }
}
