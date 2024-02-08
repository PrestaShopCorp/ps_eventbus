# PS Eventbus E2E Env

## Table of Contents

- [Introduction](#introduction)
- [Installation](#installation)
- [Usage](#usage)
- [Contributions](#contributions)
- [Licence](#licence)

## Introduction

Enabling the startup of a complete stack to perform E2E tests on `ps_eventbus`.
stack consists of the following elements:

- A storefront under Flashlight (with a mock of `ps_account` and a local link to `ps_eventbus`);
- A MySQL database;
- PHPMyAdmin;
- A mock of the CloudSync APIs.

For the CloudSync APIs mock, it is a NodeJS application simulating the CloudSync APIs. Requests made by `ps_eventbus` to CloudSync are redirected to the mock using a reverse proxy (nginx).
When a request reaches the mock, it utilizes WebSockets to transmit the said request from `ps_eventbus` to the E2E tests, allowing validation of the information coming out of `ps_eventbus`.

## Installation

1. Clone the repository.:

```bash
git clone https://github.com/PrestaShopCorp/ps_eventbus.git
cd ps_eventbus/e2e-env
```

2. Build the Docker configuration:

```
docker compose build --no-cache
```

3. start docker environment:

```
docker compose up
```

Or in detached mode:

```
docker compose up -d
```

Or specifically only starting PrestaShop (and its dependencies) with special commands to be sure your containers and volumes will be recreacted/renewed:

```
docker compose up prestashop --force-recreate --renew-anon-volumes
```

## Usage

Once the stack is started under Docker, simply navigate to the e2e directory and run the E2E tests.
