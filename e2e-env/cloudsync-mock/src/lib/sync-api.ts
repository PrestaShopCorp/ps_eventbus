import {Server} from "./server";
import {WsServer} from "./ws-server";

export class SyncApiServer extends Server {
  public constructor(probe: WsServer) {
    super(probe);

    this.api.get("/job/:id", (req, res) => {
      const jobId = req.params.id;
      if (jobId.startsWith("valid-job-")) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}
