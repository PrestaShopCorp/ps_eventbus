import { SyncApiServer, CollectorApiServer } from './helpers/api-mock';
import testConfig from './helpers/test.config';

const syncApi = new SyncApiServer(testConfig.syncApiPort);
const collectorApi = new CollectorApiServer(testConfig.collectorApiPort);

export default { syncApi, collectorApi };
