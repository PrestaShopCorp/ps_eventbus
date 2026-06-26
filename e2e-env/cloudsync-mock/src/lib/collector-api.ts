import { Server } from "./server";
import { WsServer } from "./ws-server";
// @ts-expect-error we don't care about packaging here
import multer from "multer";
import * as fs from "fs";
import * as path from "path";

const storage = multer.memoryStorage();
const upload = multer({ storage });

const DUMP_DIR = process.env.DUMP_DIR;
const DUMP_LABEL = process.env.DUMP_LABEL || "unknown";

export class CollectorApiServer extends Server {
  public constructor(probe: WsServer) {
    super(probe);

    this.api.post("/upload/:jobid", upload.single("file"), (req, res) => {
      const jobId = req.params.jobid;
      if (jobId.startsWith("valid-job-")) {
        const raw = req.file.buffer.toString();
        req.body.file = raw.split("\n").map((line) => JSON.parse(line.trim()));

        if (DUMP_DIR) {
          const shopContent = (jobId.match(/^valid-job-([^-]+)/) || [])[1] || "unknown";
          const dir = path.join(DUMP_DIR, DUMP_LABEL);
          fs.mkdirSync(dir, { recursive: true });
          const file = path.join(dir, `${shopContent}-${Date.now()}.ndjson`);
          fs.writeFileSync(file, raw);
        }

        res.status(201).end();
      } else {
        res.status(500).end();
      }
    });
  }
}
