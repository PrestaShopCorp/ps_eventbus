import { WebSocketServer } from 'ws';

export class Ws {
    private static instance: Ws;
    private static server: WebSocketServer;

    private constructor() { }

    public static getInstance(): Ws {
        if (!Ws.instance) {
            Ws.instance = new Ws();

            Ws.server = new WebSocketServer({ port: 8080 });

            console.log(`WS server started on port \x1b[96m8080\x1b[0m`);
        }

        return Ws.instance;
    }

    public sendDataToWS(request: any) {
        console.log('request test');

        Ws.server.on('connection', function connection(ws) {
            ws.send('request test');
        });
    }
}
