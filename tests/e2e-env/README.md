# PS EventBus E2E

## Run tests

Start the env:

```
docker compose --project-name ps_eventbus up -d
```

## Configuring E2E env

```sh
cp .env.dist .env
```

## Configuring tests

Test configuration can ber found in `./test-suite/config.test.ts`. You may want to run the tests within the docker environment, in that very case, use `RUN_IN_DOCKER=1` in your docker-compose.yml
