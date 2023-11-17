# PS EventBus

[![Quality Control](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/eventbus-qc-php.yml/badge.svg)](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/eventbus-qc-php.yml)

`ps_eventbus` is a module companion for CloudSync.

## Compatibility matrix

| PrestaShop platform | PS EventBus     |
| ------------------- | --------------- |
| 8.0                 | 2.x - PHP 7.1+  |
| 1.7.0-1.7.8         | 2.x - PHP 7.1+  |
| 1.6.1.x24+          | 2.4+ - PHP 7.1+ |

PS Accounts compatibility matrix [can be viewed here](https://github.com/PrestaShopCorp/ps_accounts#compatibility-matrix).

## Use

```sh
make help        # get help on how to use the awesome Makefile features
make             # bundle all vendors required for the module to run
make version     # update the package configuration to the current version
make zip         # make a zip ready to be tested in PrestaShop (see ./dist)
```

> Pro tip: prefix all you make commands with the variables you want to override. Ie: `VERSION=v1.2.3-rc4 make version` to set the package do the desired version.

## Testing

```sh
make lint              # linting the code with vendor/bin/php-cs-fixer
make lint-fix          # linting and fixing the code with vendor/bin/php-cs-fixer
make php-lint          # linting with php
make phpunit           # unit testing with vendor/bin/phpunit
make phpunit-coverage  # unit testing as above but with code coverage
make phpstan           # linting the code with PrestaShop and vendor/bin/phpstan

make docker-<stuff>    # same as above, but within a docker container
```

> Note: you will need [xdebug](https://xdebug.org/) if you want to generate the code-coverage of this project. You may install it with: `pecl install -f xdebug`.

## Healthiness

To check the module healthiness:

```sh
BASE_URL="http://localhost:8000"
curl -s -L "$BASE_URL/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck" | jq .
{
  "prestashop_version": "1.6.1.24",
  "ps_eventbus_version": "x.y.z",
  "ps_accounts_version": "5.6.2",
  "php_version": "7.1.33",
  "ps_account": true,
  "is_valid_jwt": true,
  "ps_eventbus": true,
  "env": {
    "EVENT_BUS_PROXY_API_URL": "http://reverse-proxy/collector",
    "EVENT_BUS_SYNC_API_URL": "http://reverse-proxy/sync-api"
  },
  "httpCode": 200
}
```
