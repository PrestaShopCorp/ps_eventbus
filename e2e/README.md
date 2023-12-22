# Guideline to write E2E test

To write an end-to-end (E2E) test for ps_eventbus, it is necessary to control both the response from ps_eventbus when making a request to its APIs and to control the request that ps_eventbus makes itself towards the CloudSync APIs.

To achieve this, the tests work with two components:

- Supertest:
    This allows making assertions on the request to ps_eventbus and validating the response sent by ps_eventbus directly.
- Websocket Client Usage:
    With Websockets, we are able to listen to the requests that ps_eventbus makes towards the CloudSync APIs.

# How to clearly write E2E test

exemple
```javascript
import { MockProbe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';

const controller = 'apiCategories';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=${controller}&limit=5`;

describe('CategoriesController', () => {
  let mockProbe: MockProbe;

  beforeEach(async () => {
    // instantiate the probe
    mockProbe = new MockProbe();
  });

  it('should be defined', () => {
    expect(testConfig.prestashopUrl).toBeDefined();
  });

  it('should return 454 with an invalid job id (sync-api status 454)', async () => {
    /**
     * initialize the connection with probe,
     * and pass into parameter the response count awaiting 
     */
    const probe = mockProbe.waitForMessages(1);
    const jobId = `invalid-job-${Date.now()}`;

    // assert the result of request with supertest
    await request(testConfig.prestashopUrl)
      .get(`${endpoint}&job_id=${jobId}`)
      .set('Host', testConfig.prestaShopHostHeader)
      .redirects(1)
      .expect('content-type', /json/)
      .expect(454);

    /**
     * await the stack of messages from probe
     * the probe return an Array
     */
    const syncApiRequest = await probe;
    
    // assert the request send from ps_eventbus to CloudSync API
    expect(syncApiRequest[0].method).toBe('GET');
    expect(syncApiRequest[0].url.split( '/' )).toContain(jobId);
  });

  afterEach(() => {
    // Close the connection of probe
    mockProbe.close();
  });
});
```
