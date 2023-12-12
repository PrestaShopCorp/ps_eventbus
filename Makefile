.PHONY: help build version zip zip-e2e zip-inte zip-preprod zip-prod build test composer-validate translation-validate lint docker-lint lint-fix docker-fix-lint php-cs-fixer php-cs-fixer-lint lint-fix docker-lint-fix php-lint docker-php-lint phpunit docker-phpunit phpunit-cov docker-phpunit-cov phpstan docker-phpstan phpstan-baseline docker-test
PHP = $(shell command -v php >/dev/null 2>&1 || { echo >&2 "PHP is not installed."; exit 1; } && which php)
VERSION ?= $(shell git describe --tags 2> /dev/null || echo "0.0.0")
SEM_VERSION ?= $(shell echo ${VERSION} | sed 's/^v//')
PACKAGE ?= ps_eventbus-${VERSION}
BUILDPLATFORM ?= linux/amd64
PHP_VERSION ?= 8.1
PS_VERSION ?= 8.1.2
TESTING_IMAGE ?= prestashop/prestashop-flashlight:${PS_VERSION}-${PHP_VERSION}
PS_ROOT_DIR ?= $(shell pwd)/prestashop/prestashop-${PS_VERSION}
export PATH := ./vendor/bin:./tools/vendor/bin:$(PATH)

define replace_version
sed -i.bak -e "s/\(VERSION = \).*/\1\'${2}\';/" ${1}/ps_eventbus.php
sed -i.bak -e "s/\($this->version = \).*/\1\'${2}\';/" ${1}/ps_eventbus.php
sed -i.bak -e "s|\(<version><!\[CDATA\[\)[0-9a-z.-]\{1,\}]]></version>|\1${2}]]></version>|" ${1}/config.xml
rm -f ${1}/ps_eventbus.php.bak ${1}/config.xml.bak
endef

define zip_it
$(eval TMP_DIR := $(shell mktemp -d))
mkdir -p ${TMP_DIR}/ps_eventbus;
cp -r $(shell cat .zip-contents) ${TMP_DIR}/ps_eventbus;
$(call replace_version,${TMP_DIR}/ps_eventbus,${SEM_VERSION})
./tools/vendor/bin/autoindex prestashop:add:index ${TMP_DIR}
cp $1 ${TMP_DIR}/ps_eventbus/config/parameters.yml;
cd ${TMP_DIR} && zip -9 -r $2 ./ps_eventbus;
mv ${TMP_DIR}/$2 ./dist;
rm -rf ${TMP_DIR:-/dev/null};
endef

define in_docker
docker run \
--env _PS_ROOT_DIR_=/var/www/html \
--workdir /var/www/html/modules/ps_eventbus \
--volume $(shell pwd):/var/www/html/modules/ps_eventbus:rw \
--entrypoint $1 ${TESTING_IMAGE} $2
endef

# target: default                                - Calling build by default
default: build

# target: help                                   - Get help on this file
help:
	@egrep "^#" Makefile

# target: clean                                  - Clean up the repository
clean:
	git -c core.excludesfile=/dev/null clean -X -d -f

# target: version                                - Replace version in files, CI only
version:
	@$(call replace_version,$(shell pwd),${SEM_VERSION})

# target: zip                                    - Make zip bundles
zip: zip-prod zip-preprod zip-inte
dist:
	@mkdir -p ./dist

# target: zip-e2e                                - Bundle a local E2E integrable zip
zip-e2e: vendor dist
	@$(call zip_it,./config/parameters.yml,${PACKAGE}_e2e.zip)

# target: zip-inte                               - Bundle an integration zip
zip-inte: vendor dist
	@$(call zip_it,.config.inte.yml,${PACKAGE}_integration.zip)

# target: zip-preprod                            - Bundle a preproduction zip
zip-preprod: vendor dist
	@$(call zip_it,.config.preprod.yml,${PACKAGE}_preproduction.zip)

# target: zip-prod                               - Bundle a production zip
zip-prod: vendor dist
	@$(call zip_it,.config.prod.yml,${PACKAGE}.zip)

# target: build                                  - Setup PHP & Node.js locally
build: vendor tools/vendor

composer.phar:
	@php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');";
	@php composer-setup.php;
	@php -r "unlink('composer-setup.php');";

vendor: composer.phar
	./composer.phar install --no-dev -o;

tools/vendor: composer.phar vendor
	./composer.phar install --working-dir tools -o;
	sed -i -e 's|%currentWorkingDirectory%/vendor|%currentWorkingDirectory%/tools/vendor|g' ./tools/vendor/prestashop/php-dev-tools/phpstan/ps-module-extension.neon

prestashop:
	@mkdir -p ./prestashop

prestashop/prestashop-${PS_VERSION}: prestashop composer.phar
	@if [ ! -d "prestashop/prestashop-${PS_VERSION}" ]; then \
		git clone --depth 1 --branch ${PS_VERSION} https://github.com/PrestaShop/PrestaShop.git prestashop/prestashop-${PS_VERSION} > /dev/null; \
		if [ "${PS_VERSION}" != "1.6.1.24" ]; then \
			./composer.phar -d ./prestashop/prestashop-${PS_VERSION} install; \
    fi \
	fi;

# target: test                                   - Static and unit testing
test: composer-validate lint php-lint phpstan phpunit translation-validate

# target: composer-validate                      - Validates composer.json and composer.lock
composer-validate: vendor
	@./composer.phar validate --no-check-publish

# target: translation-validate                   - Validates the translation files in translations/ directory
translation-validate:
	php tests/translation.test.php

# target: lint (or docker-lint)                  - Lint the code and expose errors
lint: php-cs-fixer php-lint
docker-lint: docker-php-cs-fixer docker-php-lint

# target: lint-fix (or docker-fix-lint)          - Automatically fix the linting errors
lint-fix: php-cs-fixer-fix
docker-lint-fix: docker-php-cs-fixer-fix

# target: php-cs-fixer (or php-cs-fixer-lint)    - Lint the code and expose errors
php-cs-fixer: tools/vendor
	@PHP_CS_FIXER_IGNORE_ENV=1 php-cs-fixer fix --dry-run --diff --using-cache=no;
docker-php-cs-fixer: tools/vendor
	@$(call in_docker,make,lint)

# target: lint-fix (or docker-lint-fix)          - Lint the code and fix it
php-cs-fixer-fix: tools/vendor
	@PHP_CS_FIXER_IGNORE_ENV=1 php-cs-fixer fix --using-cache=no;
docker-lint-fix: tools/vendor
	@$(call in_docker,make,lint-fix)

# target: php-lint (or docker-php-lint)          - Lint the code with the php linter
php-lint:
	@git ls-files | grep -E '.*\.(php)' | xargs -n1 php -l -n | (! grep -v "No syntax errors" );
	@echo "php $(shell php -r 'echo PHP_VERSION;') lint passed";
docker-php-lint:
	@$(call in_docker,make,php-lint)

# target: phpunit (or docker-phpunit)            - Run phpunit tests
phpunit: tools/vendor
	phpunit --configuration=./tests/phpunit.xml;
docker-phpunit: tools/vendor
	@$(call in_docker,make,phpunit)

# target: phpunit-cov (or docker-phpunit-cov)    - Run phpunit with coverage and allure
phpunit-cov: tools/vendor
	php -dxdebug.mode=coverage phpunit --coverage-html ./coverage-reports/coverage-html --configuration=./tests/phpunit-cov.xml;
docker-phpunit-cov: tools/vendor
	@$(call in_docker,make,phpunit-cov)

# target: phpstan (or docker-phpstan)            - Run phpstan
phpstan: tools/vendor prestashop/prestashop-${PS_VERSION}
	_PS_ROOT_DIR_=${PS_ROOT_DIR} phpstan analyse --memory-limit=256M --configuration=./tests/phpstan/phpstan.neon;
docker-phpstan: tools/vendor
	@$(call in_docker,phpstan,analyse --memory-limit=256M --configuration=./tests/phpstan/phpstan.neon)

# target: phpstan-baseline                       - Generate a phpstan baseline to ignore all errors
phpstan-baseline: prestashop/prestashop-${PS_VERSION} phpstan
	_PS_ROOT_DIR_=${PS_ROOT_DIR} phpstan analyse --generate-baseline --memory-limit=256M --configuration=./tests/phpstan/phpstan.neon;

# target: docker-test                            - Static and unit testing in docker
docker-test: docker-lint docker-phpstan docker-phpunit

# Fixme: add "allure-framework/allure-phpunit" in composer.json to solve this.
# Currently failing to resolve devDeps:
#   - allure-framework/allure-phpunit v2.1.0 requires phpunit/phpunit ^9 -> found phpunit/phpunit[9.0.0, ..., 9.6.4] but it conflicts with your root composer.json require (^10.0.14).
# allure:
# 	./node_modules/.bin/allure serve build/allure-results/

# allure-report:
# 	./node_modules/.bin/allure generate build/allure-results/
