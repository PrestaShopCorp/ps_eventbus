import { Server } from "./server";

export class CollectorApiServer extends Server {
  constructor(port: string) {
    super(parseInt(port));

    this.server.get("/", (_req, res) => {
      res.status(200).end();
    });

    this.server.post("/upload/:job_id", (req, res) => {
      const jobId = req.params.job_id;
      if (jobId.startsWith("valid-job-")) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}
