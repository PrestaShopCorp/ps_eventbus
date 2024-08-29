# e2e testing ps_eventbus

ps_eventbus works by listening to calls and pushing data to the Cloudsync server synchronously.
In order to test the calls made to Cloudsync, tests connect to mock Cloudsync servers using Websocket.

## Running tests

First start e2e environment in ```e2e-env``` (see e2e-env [README.md](../e2e-env/README.md)) then simply run ```pnpm test:e2e```.

## Writing tests

The `MockProbe` object allows to connect to a mock and check uploaded contents against the query we made.

example :
```typescript
import { MockProbe } from './helpers/mock-probe';
import testConfig from './helpers/test.config';
import request from 'supertest';

const controller = 'categories';
const endpoint = `/index.php?fc=module&module=ps_eventbus&controller=apiFront&is_e2e=1&shop_content=${shopContent}&limit=5`;

describe('CategoriesShopContent', () => {
  it(`${shopContent} should upload to collector`, async () => {
    // arrange
    const url = `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiFront&is_e2e=1&shop_content=${shopContent}&limit=5&full=1&job_id=${jobId}`;
    // jobId starting with "valid-job-" will be considered valid by the mock sync-api and will always return 201;
    // other values will be rejected by the mock
    const jobId = 'valid-job-1'
    // get values sent to the mock as Observable.
    // only values maching the given parameter will be received, which allows to exclude values sent by other tests.
    // The obsevable given by ```probe()``` establishes a websocket connection with the mock only on first subscribe,
    // but the mock accounts for that by replaying messages received a few seconds before.
    // As such, timing is not critical here.
    const message$ = probe({ url: `/upload/${jobId}` });

    // Define a random callId. This param is set into body for define the compat with PHP 5.6,
    // with header 'Content-Type': 'application/x-www-form-urlencoded'
    const callId = { 'call_id': Math.random().toString(36).substring(2, 11) };

    // act
    // call ps_eventbus api, which should in turn upload data to the mock.
    const request$ = from(
      axios.post(url, callId, {
        headers: {
          Host: testConfig.prestaShopHostHeader,
          'Content-Type': 'application/x-www-form-urlencoded' // for compat PHP 5.6
        },
      })
    );

    const results = await lastValueFrom(
      // collect both from
      // - ps_eventbus responses
      // - messages from the mock sent through the probe
      // in this example, only one request is made and as such, only one message should be received, but because
      // we're using observables, we can make an arbitrary number of requests.
      zip(message$, request$).pipe(
        map((result) => ({
          probeMessage: result[0],
          psEventbusReq: result[1],
        })),
        toArray()
      )
    );

    // assert
    expect(results.length).toEqual(1);
    expect(results[0].probeMessage.method).toBe("POST");
    expect(results[0].probeMessage.headers).toMatchObject({
      "full-sync-requested": "1",
    });
  });
});
```

## Using fixtures

Fixtures for prestashop versions should be placed in [src/fixtures](src/fixtures). The correct version is loaded 
automatically by ```loadFixture()```. If no fixture matches the version given by prestashop's healthcheck,
[src/fixtures/latest](src/fixtures/latest) is loaded instead.

```dumpUploadData()``` will write data in [dumps](dumps) using the same format used by ```loadFixture()```
to make it easier to make or update fixtures.
