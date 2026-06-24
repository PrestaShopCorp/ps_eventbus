# PS Eventbus e2e Env

## Introduction

Enabling the startup of a complete stack to perform e2e tests on `ps_eventbus`.
Stack consists of the following elements:

- A storefront under Flashlight (with a mock of `ps_account` and a local link to `ps_eventbus`);
- A MySQL database;
- PHPMyAdmin;
- A mock of the CloudSync APIs.

For the CloudSync APIs mock, it is a Node.js application simulating the CloudSync APIs. Requests made by `ps_eventbus` to CloudSync are redirected to the mock using a reverse proxy (nginx).
When a request reaches the mock, it uses WebSockets to transmit the said request from `ps_eventbus` to the E2E tests, allowing validation of the information coming out of `ps_eventbus`.

## Troubleshooting

The end-to-end environment relies on PrestaShop Flashlight, which by default runs scripts and php with the user `www-data`. This user is mapped on the uid/gid _1000_, which might perfectly match your own Linux system user.

However, if for any reason your uid is not 1000, you might disable code mentioned with this comment : `# Notice: you might enable this if your uid is not 1000, or encounter permission issues`. One thing you will loose, is the ability to hot-reload local vendors on your host to the guest docker container. Docker compose down/up will be your friend in that very case.

If you are a macOS user, mounting a docker won't cause any issue, as the process isolation is greater (and slower).

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

Or specifically, only starting PrestaShop (and its dependencies) with special commands to be sure your containers and volumes will be recreacted/renewed:

```shell
docker compose up prestashop --force-recreate --renew-anon-volumes
```

## Testing

Simple!

Is the module healthy?

```sh
curl -s "http://localhost:8000/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck&job_id=valid-job-1" | jq .
```

Capture orders:

```sh
curl -s "http://localhost:8000/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=orders&job_id=valid-job-1" | jq .
```

## Make changes to the mock

If you need to make change to the mocks, they can be built and run locally using scripts in `package.json`.
Don't forget to rebuild your docker image for your changes to take effect immediately :

```shell
docker compose build --no-cache
```

## Usage

Once the environment is running, navigate to the e2e directory and run the e2e tests.

## Production profile (real ps-accounts + real CloudSync)

Use the `production` profile to point the e2e shop at the real CloudSync prod URLs (from `.config.prod.php`) and authenticate against real `ps-accounts` via a Cloudflare tunnel.

1. Create a Cloudflare tunnel and credentials file:

   ```shell
   cloudflared tunnel login                       # opens browser, picks a zone
   cloudflared tunnel create ps-eventbus-e2e      # outputs <TUNNEL_UUID>.json credentials
   cloudflared tunnel route dns ps-eventbus-e2e <your-hostname>.example.com
   cp ~/.cloudflared/<TUNNEL_UUID>.json ./credentials.json
   ```

   The `credentials.json` file must contain the tunnel credentials (`AccountTag`, `TunnelSecret`, `TunnelID`).

2. Configure `.env`:

   ```env
   COMPOSE_PROFILES=production
   TUNNEL_NAME=<your-hostname>.example.com
   ```

3. Start the stack:

   ```shell
   docker compose up
   ```

   The `prestashop-prod` service mounts `../.config.prod.php` over the module's `config.php`, so requests go to:
   - `https://eventbus-proxy.psessentials.net`
   - `https://eventbus-sync.psessentials.net`
   - `https://api.cloudsync.prestashop.com/live-sync/v1`

   The `cloudsync-mock` and `reverse-proxy` containers are not started under this profile.
