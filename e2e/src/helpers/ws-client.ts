import WebSocket from 'ws';

type MockProbeResponse = {
    body: any;
    headers: Array<string>;
    baseUrl: string;
    query: Record<string, unknown>;
}

export class WsClient {
    wsConnection: WebSocket;

    constructor() {
        /* this.wsConnection = new WebSocket(testConfig.mockProbeUrl); */
        this.wsConnection = new WebSocket('ws://localhost:8080');
    }

    async registerMockProbe(): Promise<MockProbeResponse> {
        return new Promise((resolve, reject) => {
            const timeOutTimer = setTimeout(() => {
                this.wsConnection.terminate();
        
                reject('No message received from websocket server');
            }, 4000);
        
            this.wsConnection.on('message', (data) => {
                clearTimeout(timeOutTimer);
                resolve(JSON.parse(data.toString()));
            });
        });
    }

    close() {
        this.wsConnection.close();
    }
}
