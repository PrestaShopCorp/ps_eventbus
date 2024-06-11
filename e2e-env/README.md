# PS Eventbus e2e Env

## Introduction

Enabling the startup of a complete stack to perform e2e tests on `ps_eventbus`.
stack consists of the following elements:

- A storefront under Flashlight (with a mock of `ps_account` and a local link to `ps_eventbus`);
- A MySQL database;
- PHPMyAdmin;
- A mock of the CloudSync APIs.

For the CloudSync APIs mock, it is a NodeJS application simulating the CloudSync APIs. Requests made by `ps_eventbus` to CloudSync are redirected to the mock using a reverse proxy (nginx).
When a request reaches the mock, it utilizes WebSockets to transmit the said request from `ps_eventbus` to the E2E tests, allowing validation of the information coming out of `ps_eventbus`.

## Start the environment

1. Create your own configuration from the default values:
```shell
cp .env.dis .env
```

2. start docker environment:
```shell
docker compose up
```

Or in detached mode:
```shell
docker compose up -d
```

Or specifically only starting PrestaShop (and its dependencies) with special commands to be sure your containers and volumes will be recreacted/renewed:
```shell
docker compose up prestashop --force-recreate --renew-anon-volumes
```

## Make changes to the mock

If you need to make change to the mocks, they can be built and run locally using scripts in ```package.json```.
Don't forget to rebuild your docker image for your changes to take effect immediately :
```shell
docker compose build --no-cache
```

## Usage

Once the environment is running, simply navigate to the e2e directory and run the e2e tests.
