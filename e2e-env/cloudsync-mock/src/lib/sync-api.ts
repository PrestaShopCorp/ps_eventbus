import { Server } from "./server";

export class SyncApiServer extends Server {
  constructor(port: string) {
    super(parseInt(port));

    this.server.get("/", (_req, res) => {
      res.status(200).end();
    });

    this.server.get("/job/:id", (req, res) => {
      const jobId = req.params.id;
      if (jobId.startsWith("valid-job-")) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}
