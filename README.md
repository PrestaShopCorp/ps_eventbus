# PS EventBus

[![Quality Control](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/eventbus-qc-php.yml/badge.svg)](https://github.com/PrestaShopCorp/ps_eventbus/actions/workflows/eventbus-qc-php.yml)

`ps_eventbus` is a module companion for CloudSync.

## Compatibility matrix

| PrestaShop platform | PS EventBus    |
| ------------------- | -------------- |
| 8.0                 | 2.x - PHP 7.1+ |
| 1.7.0-1.7.8         | 2.x - PHP 7.1+ |
| 1.6.1.x             | No             |

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
