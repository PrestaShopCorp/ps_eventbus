.PHONY: clean help build bundle zip version bundle-prod bundle-inte build-back test static-testing unit-testing
PHP = $(shell command -v php >/dev/null 2>&1 || { echo >&2 "PHP is not installed."; exit 1; } && which php)
COMPOSER = $(shell which composer | which ./composer.phar 2> /dev/null)

VERSION ?= $(shell git describe --tags 2> /dev/null || echo "0.0.0")
SEM_VERSION ?= $(shell echo ${VERSION} | sed 's/^v//')
PACKAGE ?= "ps_eventbus-${VERSION}"
PHPUNIT_DOCKER ?= jitesoft/phpunit:8.1
PHPSTAN_DOCKER ?= ghcr.io/phpstan/phpstan:1.8.6-php8.2
TESTING_DOCKER_IMAGE ?= ps-eventbus-testing:latest
TESTING_DOCKER_BASE_IMAGE ?= phpdockerio/php73-cli
PS_ROOT_DIR ?= $(shell pwd)/prestashop
PS_VERSION ?= 1.7.8.7

# target: default                                - Calling build by default
default: build

# target: help                                   - Get help on this file
help:
	@egrep "^#" Makefile

# target: build                                  - Clean up the repository
clean:
	git -c core.excludesfile=/dev/null clean -X -d -f

# target: version                                - Replace version in files
version:
	echo "...$(VERSION)..."
	sed -i.bak -e "s/\(VERSION = \).*/\1\'${SEM_VERSION}\';/" ps_eventbus.php
	sed -i.bak -e "s/\($this->version = \).*/\1\'${SEM_VERSION}\';/" ps_eventbus.php
	sed -i.bak -e "s|\(<version><!\[CDATA\[\)[0-9a-z.-]\{1,\}]]></version>|\1${SEM_VERSION}]]></version>|" config.xml
	rm -f ps_eventbus.php.bak config.xml.bak

# target: zip                                    - Make zip bundles
zip: zip-prod zip-inte

# target: zip-prod                               - Bundle a production zip
zip-prod: vendor
	mkdir -p ./dist
	cd .. && zip -r ${PACKAGE}.zip ps_eventbus -x '*.git*' \
	  ps_eventbus/dist/\* \
	  ps_eventbus/composer.phar \
	  ps_eventbus/Makefile \
		ps_eventbus/.env.dist
	mv ../${PACKAGE}.zip ./dist

# target: zip-inte                               - Bundle a integration zip
zip-inte: vendor
	mkdir -p ./dist
	cp .env.inte.yml config/parameters.yml 2>/dev/null || echo "WARNING: no integration config file found";
	cd .. && zip -r ${PACKAGE}_integration.zip ps_eventbus -x '*.git*' \
	  ps_eventbus/dist/\* \
	  ps_eventbus/composer.phar \
	  ps_eventbus/Makefile \
		ps_eventbus/.env.dist
	mv ../${PACKAGE}_integration.zip ./dist

# target: zip-inte                               - Bundle a integration zip
zip-preproduction: vendor
	mkdir -p ./dist
	cp .env.inte.yml config/parameters.yml 2>/dev/null || echo "WARNING: no preproduction config file found";
	cd .. && zip -r ${PACKAGE}_preproduction.zip ps_eventbus -x '*.git*' \
	  ps_eventbus/dist/\* \
	  ps_eventbus/composer.phar \
	  ps_eventbus/Makefile \
		ps_eventbus/.env.dist
	mv ../${PACKAGE}_preproduction.zip ./dist

# target: build                                  - Setup PHP & Node.js locally
build: vendor

vendor:
	@if [ "$(COMPOSER)" = "" ]; then \
	echo "Installing composer locally"; \
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
	php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"; \
	php composer-setup.php; php -r "unlink('composer-setup.php');"; \
	./composer.phar install --no-dev -o; \
	else ${COMPOSER} install --no-dev -o; \
	fi

vendor/bin/php-cs-fixer:
	${COMPOSER} install

# target: test                                   - Static and unit testing
test: lint phpstan phpunit 

# target: lint                                   - Lint the code and expose errors
lint: vendor/bin/php-cs-fixer
	vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no;

# target: lint-fix                               - Lint the code and fix it
lint-fix:
	vendor/bin/php-cs-fixer fix --using-cache=no;

# target: phpunit                                - Run phpunit
phpunit: vendor/bin/phpunit
	vendor/bin/phpunit tests;

# target: prestashop                             - Download prestashop source code
prestashop:
	git clone --depth 1 --branch ${PS_VERSION} git@github.com:PrestaShop/PrestaShop.git prestashop;
	${COMPOSER} -d ./prestashop install

# target: phpstan                                - Run phpstan
phpstan: prestashop
	_PS_ROOT_DIR_=${PS_ROOT_DIR} phpstan analyse --configuration=./tests/phpstan/phpstan.neon;

# target: docker-test                            - Static and unit testing in docker
docker-test: docker-lint phpstan phpunit 

# target: docker-lint                            - Lint the code in docker
docker-lint:
	docker run \
	--rm -w /var/www/html \
	-e "_PS_ROOT_DIR_=/var/www/html" \
	-v $(shell pwd):/var/www/html \
	${TESTING_DOCKER_IMAGE} \
	-c "make lint";

# target: testing-docker-image                    - Build a local testing docker image
testing-docker-image: .cache/testing-image-built
.cache/testing-image-built:
	-docker run --name 7ghqQ3jgzpr9DZfg56 --entrypoint /bin/sh ${TESTING_DOCKER_BASE_IMAGE} -c "apt-get -qqy update && apt-get -qqy install make"
	-docker commit 7ghqQ3jgzpr9DZfg56 ${TESTING_DOCKER_IMAGE}
	-docker rm 7ghqQ3jgzpr9DZfg56
	-mkdir -p .cache
	-touch .cache/testing-image-built
	
# target: docker-phpunit                         - Run phpunit in docker
docker-phpunit:
	docker run \
	--rm \
	-w /phpunit \
	-v $(shell pwd):/phpunit \
	${TESTING_DOCKER_IMAGE} \
	-c "make phpunit";

# target: docker-phpstan                         - Run phpstan in docker
docker-phpstan:
	docker run \
	--rm -w /var/www/html \
	-e "_PS_ROOT_DIR_=/var/www/html" \
	-v $(shell pwd):/var/www/html \
	${TESTING_DOCKER_IMAGE} \
	-c "make phpstan";

bps177: build-ps-177
ata177: all-tests-actions-177
rda177: run-docker-actions-177
build-ps-177:
	-docker exec -i prestashop-177 sh -c "rm -rf /var/www/html/install"
	-docker exec -i prestashop-177 sh -c "mv /var/www/html/admin /var/www/html/admin1"
	mysql -h 127.0.0.1 -P 9001 --protocol=tcp -u root -pprestashop prestashop < $(shell pwd)/tests/System/Seed/Database/177.sql
	docker exec -i prestashop-177 sh -c "cd /var/www/html && php  bin/console prestashop:module install eventBus"

run-docker-actions-177:
	docker-compose up -d --build --force-recreate prestashop-177
	/bin/bash .docker/wait-for-container.sh sq-mysql

all-tests-actions-177:
	make rda177
	make bps177
	docker exec -i prestashop-177 sh -c "cd /var/www/html/modules/ps_eventbus && php vendor/bin/phpunit -c tests/phpunit.xml"

allure:
	./node_modules/.bin/allure serve build/allure-results/

allure-report:
	./node_modules/.bin/allure generate build/allure-results/


