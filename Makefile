.PHONY: clean help build bundle zip version bundle-prod bundle-inte build-back test static-testing unit-testing
PHP = $(shell command -v php >/dev/null 2>&1 || { echo >&2 "PHP is not installed."; exit 1; } && which php)

VERSION ?= $(shell git describe --tags 2> /dev/null || echo "0.0.0")
SEM_VERSION ?= $(shell echo ${VERSION} | sed 's/^v//')
PACKAGE ?= "ps_eventbus-${VERSION}"
BUILDPLATFORM ?= linux/amd64
TESTING_DOCKER_IMAGE ?= ps-eventbus-testing:latest
TESTING_DOCKER_BASE_IMAGE ?= phpdockerio/php80-cli
PHP_VERSION ?= 8.1
PS_VERSION ?= 1.7.8.7
PS_ROOT_DIR ?= $(shell pwd)/prestashop/prestashop-${PS_VERSION}

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

composer.phar:
	@php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');";
	@php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;";
	@php composer-setup.php;
	@php -r "unlink('composer-setup.php');";

vendor: composer.phar
	./composer.phar install --no-dev -o;

vendor/bin/php-cs-fixer:
	./composer.phar install

vendor/bin/phpunit:
	./composer.phar install

vendor/bin/phpstan:
	./composer.phar install

prestashop:
	@mkdir -p ./prestashop

prestashop/prestashop-${PS_VERSION}:
	@git clone --depth 1 --branch ${PS_VERSION} https://github.com/PrestaShop/PrestaShop.git prestashop/prestashop-${PS_VERSION};
	@./composer.phar -d ./prestashop/prestashop-${PS_VERSION} install

# target: test                                   - Static and unit testing
test: composer-validate lint php-lint phpstan phpunit 

# target: composer-validate                      - Validates composer.json and composer.lock
composer-validate: vendor
	@./composer.phar validate --no-check-publish

# target: lint                                   - Lint the code and expose errors
lint: vendor/bin/php-cs-fixer
	@vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no;

# target: php-lint                               - Use php linter to check the code
php-lint:
	@git ls-files | grep -E '.*\.(php)' | xargs -n1 php -l -n | (! grep -v "No syntax errors" );
	@echo "php $(shell php -r 'echo PHP_VERSION;') lint passed";

# target: lint-fix                               - Lint the code and fix it
lint-fix:
	@vendor/bin/php-cs-fixer fix --using-cache=no;

# target: phpunit                                - Run phpunit
phpunit: vendor/bin/phpunit
	@vendor/bin/phpunit tests;

# target: phpstan                                - Run phpstan
phpstan: prestashop/prestashop-${PS_VERSION} vendor/bin/phpstan
	_PS_ROOT_DIR_=${PS_ROOT_DIR} vendor/bin/phpstan analyse --memory-limit=256M --configuration=./tests/phpstan/phpstan.neon;

# target: docker-test                            - Static and unit testing in docker
docker-test: docker-lint docker-phpstan docker-phpunit 

# target: docker-lint                            - Lint the code in docker
docker-lint:
	docker run --rm -w /src \
	-v $(shell pwd):/src \
	${TESTING_DOCKER_IMAGE} \
	-c "make lint";

# target: docker-lint                            - Lint the code with php in docker
docker-php-lint:
	docker build --build-arg BUILDPLATFORM=${BUILDPLATFORM} --build-arg PHP_VERSION=${PHP_VERSION} -t ${TESTING_DOCKER_IMAGE} -f dev-tools.Dockerfile .;
	docker run --rm -v $(shell pwd):/src ${TESTING_DOCKER_IMAGE} php-lint;

# target: docker-phpunit                         - Run phpunit in docker
docker-phpunit:
	docker build --build-arg BUILDPLATFORM=${BUILDPLATFORM} --build-arg PHP_VERSION=${PHP_VERSION} -t ${TESTING_DOCKER_IMAGE} -f dev-tools.Dockerfile .;
	docker run --rm -v $(shell pwd):/src ${TESTING_DOCKER_IMAGE} phpunit;

# target: docker-phpstan                         - Run phpstan in docker
docker-phpstan: prestashop
	docker build --build-arg BUILDPLATFORM=${BUILDPLATFORM} --build-arg PHP_VERSION=${PHP_VERSION} -t ${TESTING_DOCKER_IMAGE} -f dev-tools.Dockerfile .;
	docker run --rm -e _PS_ROOT_DIR_=/src/prestashop/prestashop-${PS_VERSION} -v $(shell pwd):/src ${TESTING_DOCKER_IMAGE} phpstan;

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
