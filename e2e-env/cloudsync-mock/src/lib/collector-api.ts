import { Server } from "./server";

export class CollectorApiServer extends Server {
  constructor(port: string) {
    super(parseInt(port));

    this.api.get("/", (_req, res) => {
      res.status(200).end();
    });

    this.api.post("/upload/:jobid", (req, res) => {
      const jobId = req.params.jobid;
      if (jobId.startsWith("valid-job-")) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });

    this.api.post("/delete/:jobid", (req, res) => {
      const jobId = req.params.jobid;
      if (jobId.startsWith("valid-job-")) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}
