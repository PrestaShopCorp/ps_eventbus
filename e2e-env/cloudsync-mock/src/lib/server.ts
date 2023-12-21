import express, { Request, Response, Express, NextFunction } from "express";
import { WsServer } from "./ws-server";

export class Server {
  api: Express;
  port: number;

  wsServer: WsServer;

  public constructor(port: number) {
    this.api = express();
    
    this.api.use(this.middleware.bind(this));
    this.port = port;

    this.wsServer = WsServer.getInstance();
  }

  public async listen() {
    console.log(`${this.constructor.name} listening on port \x1b[96m${this.port}\x1b[0m`);
    return this.api.listen(this.port);
  }

  private middleware(req: Request, res: Response, next: NextFunction) {
    this.wsServer.sendDataToWS(this.constructor.name, req);
    next();
  }
}
