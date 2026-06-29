import { Server } from "./server";
import { WsServer } from "./ws-server";
// @ts-expect-error we don't care about packaging here
import multer from "multer";
// @ts-expect-error
import express from "express";
import * as fs from "fs";
import * as path from "path";

const storage = multer.memoryStorage();
const upload = multer({ storage });
const rawBody = express.raw({ type: "*/*", limit: "100mb" });

const DUMP_DIR = process.env.DUMP_DIR;
const DUMP_LABEL = process.env.DUMP_LABEL || "unknown";

function persistDump(jobId: string, raw: string) {
  if (!DUMP_DIR) return;
  const shopContent = (jobId.match(/^valid-job-([^-]+)/) || [])[1] || "unknown";
  const dir = path.join(DUMP_DIR, DUMP_LABEL);
  fs.mkdirSync(dir, { recursive: true });
  const file = path.join(dir, `${shopContent}-${Date.now()}.ndjson`);
  fs.writeFileSync(file, raw);
}

export class CollectorApiServer extends Server {
  public constructor(probe: WsServer) {
    super(probe);

    // multipart upload (legacy: v1.x)
    this.api.post(
      "/upload/:jobid",
      (req, res, next) => {
        const ct = (req.headers["content-type"] || "").toLowerCase();
        if (ct.startsWith("multipart/")) return upload.single("file")(req, res, next);
        return rawBody(req, res, next);
      },
      (req, res) => {
        const jobId = req.params.jobid;
        if (!jobId.startsWith("valid-job-")) {
          res.status(500).end();
          return;
        }
        let raw: string;
        if (req.file && req.file.buffer) {
          raw = req.file.buffer.toString();
        } else if (Buffer.isBuffer(req.body)) {
          raw = req.body.toString();
        } else {
          raw = typeof req.body === "string" ? req.body : JSON.stringify(req.body);
        }
        try {
          req.body = { file: raw.split("\n").filter((l) => l.trim()).map((l) => JSON.parse(l)) };
        } catch {
          req.body = { raw };
        }
        persistDump(jobId, raw);
        res.status(201).end();
      }
    );
  }
}
