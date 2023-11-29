export const config = {
  syncApiPort: process.env.SYNC_API_PORT ?? '3232',
  collectorApiPort: process.env.COLLECTOR_API_PORT ?? '3333',
  liveSyncApiPort: process.env.COLLECTOR_API_PORT ?? '3434',
};
