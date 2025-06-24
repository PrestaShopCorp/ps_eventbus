# e2e testing ps_eventbus

ps_eventbus works by listening to calls and pushing data to the Cloudsync server synchronously.
In order to test the calls made to Cloudsync, tests connect to mock Cloudsync servers using Websocket.

## Running tests

First start e2e environment in ```e2e-env``` (see e2e-env [README.md](../e2e-env/README.md)) then simply run ```pnpm run test:e2e```.

## Using fixtures

Fixtures for prestashop versions should be placed in [src/fixtures](V2/src/data/fixtures). The correct version is loaded
automatically by ```loadFixture()```. If no fixture matches the version given by prestashop's healthcheck,
[src/fixtures/latest](V2/src/data/fixtures/latest) is loaded instead.

```dumpUploadData()``` will write data in [dumps](dumps) using the same format used by ```loadFixture()```
to make it easier to make or update fixtures.
