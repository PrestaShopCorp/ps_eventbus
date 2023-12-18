import express from "express";
import { Ws } from "./ws";


export class Server {
  api: express.Express;
  port: number;

  wsServer: Ws;

  constructor(port: number) {
    this.api = express();
    this.api.use(this.middleware.bind(this));
    this.port = port;

    this.wsServer = Ws.getInstance();
  }

  middleware(req: express.Request, res: express.Response, next: express.NextFunction) {
    this.sendDataToWS(req);
    next();
  }

  sendDataToWS(req: any) {
    this.wsServer.sendDataToWS(req);
  }

  public async listen() {
    console.log(`${this.constructor.name} listening on port \x1b[96m${this.port}\x1b[0m`);
    return this.api.listen(this.port);
  }
}
