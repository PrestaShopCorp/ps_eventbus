import WebSocket from 'ws';

export class WsClient {
    wsConnection: WebSocket;

    constructor() {
        this.wsConnection = new WebSocket('ws://localhost:8080');
    }

    async listenRequestFromModule(timeOut: number) {
        return new Promise((resolve, reject) => {
            const timeOutTimer = setTimeout(() => {
                this.wsConnection.terminate();
        
                reject('No message received from websocket server');
            }, 5000);
        
            this.wsConnection.on('message', (data) => {
                clearTimeout(timeOutTimer);
                resolve(data);
            });
        });
    }

    close() {
        this.wsConnection.close();
    }
}
