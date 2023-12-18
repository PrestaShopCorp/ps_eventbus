import { CollectorApiServer } from "./lib/collector.ts";
import { SyncApiServer } from "./lib/sync-api";

const syncApi = new SyncApiServer(process.env.SYNC_API_PORT ?? "3232");
const collectorApi = new CollectorApiServer(
  process.env.COLLECTOR_API_PORT ?? "3333",
);
// const liveSyncApi = new LiveSyncApiServer(process.env.COLLECTOR_API_PORT ?? '3434');

syncApi.listen();
collectorApi.listen();
// liveSyncApi.listen();
