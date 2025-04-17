import { Server } from "./server";
import {WsServer} from "./ws-server";

export class LiveSyncApiServer extends Server {
  public constructor(probe: WsServer) {
    super( probe);

    this.api.post("/notify/:shopId", (req, res) => {
      const shopId = req.params.shopId;
      if (shopId.startsWith("valid-shopid-")) {
        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}
