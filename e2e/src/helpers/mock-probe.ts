import WebSocket, { RawData } from 'ws';

type MockProbeResponse = {
    method: string,
    headers: Record<string, unknown>,
    url: string,
    query: string,
    body: Record<string, unknown>
}

export class MockProbe {
    private static wsConnection: WebSocket;
    private static messageList = [];

    public static connect(): void {
        MockProbe.wsConnection = new WebSocket('ws://localhost:8080');
        MockProbe.wsConnection.on('message', (message: RawData) => this.insertToMessageList(message));
    }

    public static disconnect(): void {
        MockProbe.clearMessageList();
        MockProbe.wsConnection.close();
    }

    public static async waitForMessages(expectedMessageCount = 1): Promise<Array<MockProbeResponse>> {
        return new Promise((resolve, reject) => {
            let tryCount = 0;
            let attempt = 10;
            
            const interval = setInterval(() => {
                attempt++;
                
                if (MockProbe.messageList.length === expectedMessageCount) {
                    clearInterval(interval);
                    resolve(MockProbe.messageList);

                    MockProbe.clearMessageList();
                }

                if (tryCount === attempt) {
                    clearInterval(interval);
                    reject('No sufficient message received from probe');

                    MockProbe.clearMessageList();
                }
            }, 500)
        });
    }

    private static insertToMessageList(message: RawData): void {
        MockProbe.messageList.push(
            JSON.parse(message.toString())
        );
    }

    private static clearMessageList(): void {
        MockProbe.messageList = [];
    }
}
