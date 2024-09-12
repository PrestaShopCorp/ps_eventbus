# PS EventBus

[![Quality Check](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/quality-check.yml/badge.svg)](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/quality-check.yml)

`ps_eventbus` is a module companion for CloudSync.

## Compatibility matrix

| PrestaShop platform | PHP  | PS EventBus |
| ------------------- | ---- | ----------- |
| 8.0                 | 7.1+ | From 2.x    |
| 1.7.3-1.7.8         | 7.1+ | From 2.x    |
| 1.6.1.11 - 1.7.2.5  | 7.1  | From 3.1    |

PS Accounts compatibility matrix [can be viewed here](https://github.com/PrestaShopCorp/ps_accounts#compatibility-matrix).

### Product Images Issue in PHP 8.1

Please note that starting from PHP 8.1, product images may be missing due to a known issue.
This is a recognized problem and is being tracked in the PrestaShop repository.
You can follow the progress and find more details about the resolution [here](https://github.com/PrestaShop/PrestaShop/issues/36836).

## Use

```sh
make help        # get help on how to use the awesome Makefile features
make             # bundle all vendors required for the module to run
make zip         # make a zip ready to be tested in PrestaShop (see ./dist)
```

> Pro-tip: prefix all you make commands with the variables you want to override. Ie: `VERSION=v1.2.3-rc4 make zip-prod` to set the zip package to the desired version.

## Testing

```sh
make lint              # linting the code with vendor/bin/php-cs-fixer
make lint-fix          # linting and fixing the code with vendor/bin/php-cs-fixer
make php-lint          # linting with php
make phpunit           # unit testing with vendor/bin/phpunit
make phpunit-cov  # unit testing as above but with code coverage
make phpstan           # linting the code with PrestaShop and vendor/bin/phpstan

make docker-<stuff>    # same as above, but in a docker container
```

> Note: you will need [xdebug](https://xdebug.org/) if you want to generate the code-coverage of this project. You may install it with: `pecl install -f xdebug`.

## Healthiness

To check the module healthiness (authenticated route):

```sh
BASE_URL="http://localhost:8000"
curl -s -L "$BASE_URL/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck&job_id=valid-job-stuff" | jq .
{
  "prestashop_version": "1.6.1.24",
  "ps_eventbus_version": "0.0.0",
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

To check the fallback route (unauthenticated):

```sh
BASE_URL="http://localhost:8000"
curl -s -L "$BASE_URL/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck" | jq .
{
  "ps_account": true,
  "is_valid_jwt": true,
  "ps_eventbus": true,
  "env": {
    "EVENT_BUS_PROXY_API_URL": "http://reverse-proxy/collector",
    "EVENT_BUS_SYNC_API_URL": "http://reverse-proxy/sync-api",
    "EVENT_BUS_LIVE_SYNC_API_URL": "http://reverse-proxy/live-sync-api/v1"
  },
  "httpCode": 200
}
```

## Contribute

Dev requirements:

- PHP 8.2.12
- PHP Extensions
  - [DOM](https://www.php.net/manual/en/book.dom.php)
  - [SimpleXML](https://www.php.net/manual/en/book.simplexml.php)
  - [gd](https://www.php.net/manual/en/book.image.php)
  - [zip](https://www.php.net/manual/en/book.zip.php)

Or an up-to-date [Docker engine](https://docs.docker.com/engine/install).

## List of missing data in a database and why is missing

|           Object content           |        Reason        | Added in PS version | Link with more info                                                                                                                                                           |
|:----------------------------------:|:--------------------:|:-------------------:|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
|         currency.precision         | row missing in table |       1.7.6.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/37807f66b40b0cebb365ef952e919be15e9d6b2f#diff-3f41d3529ffdbfd1b994927eb91826a32a0560697025a734cf128a2c8e092a45R124)  |
|   employee.has_enabled_gravatar    | row missing in table |       1.7.8.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/20f1d9fe8a03559dfa9d1f7109de1f70c99f1874#diff-cde6a9d4a58afb13ff068801ee09c0e712c5e90b0cbf5632a0cc965f15cb6802R107)  |
|  product.additional_delivery_time  | row missing in table |       1.7.3.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/10268af8db4163dc2a02edb8da93d02f37f814d8#diff-e94a594ba740485c7a4882b333984d3932a2f99c0d6d0005620745087cce7a10R260)  |
|     product.delivery_in_stock      | row missing in table |       1.7.3.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/10268af8db4163dc2a02edb8da93d02f37f814d8#diff-e94a594ba740485c7a4882b333984d3932a2f99c0d6d0005620745087cce7a10R260)  |
|     product.delivery_out_stock     | row missing in table |       1.7.3.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/10268af8db4163dc2a02edb8da93d02f37f814d8#diff-e94a594ba740485c7a4882b333984d3932a2f99c0d6d0005620745087cce7a10R260)  |
|           stock.location           | row missing in table |       1.7.5.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/4c7d58a905dfb61c7fb2ef4a1f9b4fab2a8d8ecb#diff-e57fb1deeaab9e9079505333394d58f0bf7bb40280b4382aad1278c08c73e2e8R58)   |
|             store_lang             |    table missing     |       1.7.3.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/7dda2be62d8bd606edc269fa051c36ea68f81682#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2004) |
|             wishlist¹              |    table missing     |         n/a         | [Prestashop Addons](https://addons.prestashop.com/en/undownloadable/9131-wishlist-block.html)                                                                                 |
|             taxonomy²              |    table missing     |         n/a         | [Prestashop Addons](https://addons.prestashop.com/fr/produits-sur-facebook-reseaux-sociaux/50291-prestashop-social-with-facebook-instagram.htmll)                             |
| stock_available. physical_quantity | row missing in table |       1.7.2.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/2a3269ad93b1985f2615d6604458061d4989f0ea#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2186) |
| stock_available. reserved_quantity | row missing in table |       1.7.2.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/2a3269ad93b1985f2615d6604458061d4989f0ea#diff-e98d435095567c145b49744715fd575eaab7050328c211b33aa9a37158421ff4R2186) |
|          languages.locale          | row missing in table |       1.7.0.0       | [github](https://github.com/PrestaShop/PrestaShop/commit/481111b8274ed005e1c4a8ce2cf2b3ebbeb9a270#diff-c123d3d30d9c9e012a826a21887fccce6600a2f2a848a58d5910e55f0f8f5093R41)   |

¹ Feature enabled only with PsWishlist module</br>
² Feature enabled only with PsFacebook module
