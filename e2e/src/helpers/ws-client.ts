import WebSocket from 'ws';

type MockProbeResponse = {
    method: string,
    headers: Record<string, unknown>,
    url: string,
    query: string,
    body: Record<string, unknown>
}

export class WsClient {
    wsConnection: WebSocket;

    messagesList: Map<string, Array<Record<string, unknown>>> = new Map([
        ['sync-api', []],
        ['live-sync-api', []],
        ['collector-api', []]
    ]);

    public constructor() {
        /* this.wsConnection = new WebSocket(testConfig.mockProbeUrl); */
        this.wsConnection = new WebSocket('ws://localhost:8080');
    }

    public async registerMockProbe(): Promise<MockProbeResponse> {
        return new Promise((resolve, reject) => {
            const timeOutTimer = setTimeout(() => {
                this.wsConnection.terminate();
        
                reject('No message received from websocket server');
            }, 4000);
        
            this.wsConnection.on('message', (data) => {
                clearTimeout(timeOutTimer);

                const parsedDate = JSON.parse(data.toString());

                this.parkMessage(parsedDate.apiName, parsedDate);

                resolve(parsedDate);
            });
        });
    }

    public getNextMessage(apiName: string): Record<string, unknown> {
        const messageList = this.messagesList.get(apiName);

        return messageList.shift();
    }

    public close() {
        this.wsConnection.close();
    }

    private parkMessage(apiName: string, data: Record<string, unknown>) {
        const messageList = this.messagesList.get(apiName);
        messageList.push(data);

        this.messagesList.set(apiName, messageList);
    }
}
