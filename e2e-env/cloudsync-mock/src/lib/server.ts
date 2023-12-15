import express from "express";

export class Server {
  private server: any;
  api: any;
  port: number;
  constructor(port: number) {
    this.api = express();
    this.port = port;
    this.api.use(this.middleware.bind(this));
  }

  middleware(req, _res, next) {
    this.requestData(req);
    next();
  }

  requestData(req: any) {
    console.log("req", req);
  }

  public async close() {
    return this.server.close();
  }

  public async listen() {
    return this.server.listen(this.port);
  }
}
