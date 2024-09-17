import WebSocket from "ws";
import { WebSocketSubject } from "rxjs/webSocket";
import { EMPTY, expand, filter, from, map, Observable, timeout } from "rxjs";
import R from "ramda";
import testConfig from "./test.config";
import axios from "axios";
import { Controller } from "./controllers";

const DEFAULT_OPTIONS = {
  timeout: 500,
};

export type MockProbeOptions = typeof DEFAULT_OPTIONS;
export type MockClientOptions = typeof DEFAULT_OPTIONS;

// no Websocket implementation seems to exist in jest runner
if (!global.WebSocket) {
  // eslint-disable-next-line @typescript-eslint/no-explicit-any
  (global as any).WebSocket = WebSocket;
}

let wsConnection: Observable<MockProbeResponse> = null;
function getProbeSocket(): Observable<MockProbeResponse> {
  if (!wsConnection) {
    wsConnection = new WebSocketSubject<MockProbeResponse>(
      "ws://localhost:8080",
    );
  }
  return wsConnection;
}

export type MockProbeResponse = {
  apiName: string;
  method: string;
  headers: Record<string, string>;
  url: string;
  query: Record<string, string>;
  params: Record<string, string>;
  body: Record<string, unknown> & { file: unknown[] };
};

export function probe(
  match?: Partial<MockProbeResponse>,
  options?: MockProbeOptions,
): Observable<MockProbeResponse> {
  options = R.mergeLeft(options, DEFAULT_OPTIONS);
  const socket = getProbeSocket();

  return socket.pipe(
    filter((message) => (match ? R.whereEq(match, message) : true)),
    timeout(options.timeout),
  );
}

export type PsEventbusSyncResponse = {
  job_id: string;
  object_type: string;
  syncType: string; // 'full' | 'incremental'
  total_objects: number; // may not always be accurate, can't be relied on
  has_remaining_objects: boolean; // reliable
  remaining_objects: number; // may not always be accurate, can't be relied on
  md5: string;
  status: boolean;
  httpCode: number;
  body: unknown; // not sure what this is
  upload_url: string;
};

// TODO define collection as type literal
export type Collection = string;

export type PsEventbusSyncUpload = {
  collection: Collection;
  id: string;
  properties: unknown;
};

export function doFullSync(
  jobId: string,
  controller: Controller,
  options?: MockClientOptions,
): Observable<PsEventbusSyncResponse> {
  options = R.mergeLeft(options, DEFAULT_OPTIONS);

  const callId = { call_id: Math.random().toString(36).substring(2, 11) };

  const requestNext = (full: number) =>
    axios.post<PsEventbusSyncResponse>(
      `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5&full=${full}&job_id=${jobId}`,
      callId,
      {
        headers: {
          Host: testConfig.prestaShopHostHeader,
          "Content-Type": "application/x-www-form-urlencoded", // for compat PHP 5.6
        },
      },
    );

  return from(requestNext(1)).pipe(
    expand((response) => {
      if (response.data.has_remaining_objects) {
        return from(requestNext(0));
      } else {
        return EMPTY;
      }
    }),
    timeout(options.timeout),
    map((response) => response.data),
  );
}
