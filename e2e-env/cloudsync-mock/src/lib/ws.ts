import { WebSocketServer } from 'ws';

export class Ws {
    private static instance: Ws;
    private static server: WebSocketServer;

    private constructor() { }

    public static getInstance(): Ws {
        if (!Ws.instance) {
            Ws.instance = new Ws();

            Ws.server = new WebSocketServer({ port: 8080 });
        }

        return Ws.instance;
    }

    public sendDataToWS(req: any) {
        Ws.server.on('connection', function connection(ws) {
            ws.on('message', function incoming(message) {
                console.log('received: %s', message);
            });

            ws.send('something');
        });
    }
}
