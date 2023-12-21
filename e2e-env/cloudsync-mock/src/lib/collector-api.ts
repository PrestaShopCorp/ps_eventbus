import { Server } from "./server";

export class CollectorApiServer extends Server {
  constructor(port: string) {
    super(parseInt(port));

    this.api.get("/", (_req, res) => {
      res.status(200).end();
    });

    this.api.post("/upload/:job_id", (req, res) => {
      const jobId = req.params.job_id;
      if (jobId.startsWith("valid-job-")) {
        console.log("valid collector job received");
        res.status(201).end();
      } else {
        console.log("invalid collector job received");
        res.status(500).end();
      }
    });
  }
}