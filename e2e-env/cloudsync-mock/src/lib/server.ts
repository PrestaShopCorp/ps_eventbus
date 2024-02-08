import express, { Request, Response, Express, NextFunction } from "express";
import { WsServer } from "./ws-server";

export class Server {
  api: Express;
  port: number;

  wsServer: WsServer;

  public constructor(port: number) {
    this.api = express();

    const wsServer = WsServer.getInstance();

    this.api.use((req: Request, res: Response, next: NextFunction) => {
     wsServer.sendDataToWS(this.constructor.name, req);
      next();
    });
    this.api.use((req: Request, res: Response, next: NextFunction) => {
      //TODO : make prettier
      req.on('data', buf => console.log(buf.toString('utf8')));
      next();
    });
    this.port = port;
  }

  public async listen() {
    console.log(`${this.constructor.name} listening on port \x1b[96m${this.port}\x1b[0m`);
    return this.api.listen(this.port);
  }
}
