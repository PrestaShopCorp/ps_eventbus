# PS EventBus

[![Quality Control](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/eventbus-qc-php.yml/badge.svg)](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/eventbus-qc-php.yml)

`ps_eventbus` is a module companion for CloudSync.

## Architecture

This module opens controllers, and is called multiple times a day by the CloudSync services.
Open routes are:

** Without authentication: **

- `/apiHealthCheck`

** Authenticated routes: **

- `/apiCarriers`
- `/apiCarts`
- `/apiCategories`
- `/apiInfo`
- `/apiModules`
- `/apiOrders`
- `/apiProducts`
- `/apiGoogleTaxonomies`
- `/apiThemes`

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
make lint            # linting the code with vendor/bin/php-cs-fixer
make lint-fix        # linting and fixing the code with vendor/bin/php-cs-fixer
make php-lint        # linting with php
make phpunit         # unit testing with vendor/bin/phpunit
make phpstan         # linting the code with PrestaShop and vendor/bin/phpstanphpstan

make docker-<stuff>  # same as above, but within a docker container
```
