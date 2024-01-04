import WebSocket from 'ws';

type MockProbeResponse = {
    method: string,
    headers: Record<string, unknown>,
    url: string,
    query: string,
    body: Record<string, unknown>
}

export class MockProbe {
    private wsConnection: WebSocket;

    public constructor() {
        this.wsConnection = new WebSocket('ws://localhost:8080');
    }

    public async waitForMessages(expectedMessageCount = 1): Promise<Array<MockProbeResponse>> {
        const messageList = [];

        return new Promise((resolve, reject) => {
            let timeout: NodeJS.Timeout;

            this.wsConnection.on('message', (data) => {
                messageList.push(JSON.parse(data.toString()));
                
                if (messageList.length === expectedMessageCount) {
                    clearTimeout(timeout);
                    this.close();
                    resolve(messageList);
                }
            });

            timeout = setTimeout(() => {
                this.close();

                if (messageList.length) {
                    resolve(messageList);
                } else {
                    reject('No message received from mock probe');
                }
            }, 5000);
        });
    }

    public close() {
        if (this.wsConnection.readyState === WebSocket.CONNECTING) {
            // await connection is established and then terminate
            // is needed for the case that the connection is established and is not used
            this.wsConnection.on('open', () => this.wsConnection.terminate());

            return;
        }

        return this.wsConnection.close();
    }
}
