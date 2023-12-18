import express from "express";

export class Server {
  server: any;
  port: number;
  
  constructor(port: number) {
    this.server = express();
    this.server.use(this.middleware.bind(this));
    
    this.port = port;
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
