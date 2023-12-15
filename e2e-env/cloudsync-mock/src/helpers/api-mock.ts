import express from 'express';

class Server {
  private server: any;
  api: any;
  port: number;
  constructor(port: number) {
    this.api = express();
    this.port = port;
    this.api.use(this.middleware.bind(this));
    this.server = this.api.listen(this.port);
  }
  middleware(req, _res, next) {
    this.requestData(req);
    next();
  }
  requestData(req: any) {
    console.log('req', req);
  }
  public async close() {
    return this.server.close();
  }
}

export class SyncApiServer extends Server {
  constructor(port: string) {
    super(parseInt(port));
  
    this.api.get('/', (_req, res) => {
      res.status(200).end();
    });

    this.api.get('/job/:id', (req, res) => {
      const jobId = req.params.id;
      if (jobId.startsWith('valid-job-')) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}

export class CollectorApiServer extends Server {
  constructor(port: string) {
    super(parseInt(port));
    this.api.get('/', (_req, res) => {
      res.status(200).end();
    });
    this.api.post('/upload/:job_id', (req, res) => {
      const jobId = req.params.job_id;
      if (jobId.startsWith('valid-job-')) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}

export default { SyncApiServer, CollectorApiServer };
