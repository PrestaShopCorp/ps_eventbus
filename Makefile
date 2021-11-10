.PHONY: clean help build bundle zip version bundle-prod bundle-inte build-back
PHP = $(shell which php 2> /dev/null)
DOCKER = $(shell docker ps 2> /dev/null)
NPM = $(shell which npm 2> /dev/null)
YARN = $(shell which yarn 2> /dev/null)

VERSION ?= $(shell git describe --tags 2> /dev/null || echo "0.0.0")
SEM_VERSION ?= $(shell echo ${VERSION} | sed 's/^v//')
MODULE ?= $(shell basename ${PWD})
PACKAGE ?= "${MODULE}-${VERSION}"
PHPSTAN_VERSION ?= 0.12
PHPUNIT_VERSION ?= latest
PS_VERSION ?= 1.7.7.1
NEON_FILE ?= phpstan-PS-1.7.neon

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
zip-prod: ./vendor
	mkdir -p ./dist
	git checkout -- config/parameters.yml
	cd .. && zip -r ${PACKAGE}.zip ${MODULE} -x '*.git*' -x '*.env*' \
	  ${MODULE}/dist/\* \
	  ${MODULE}/composer.phar \
	  ${MODULE}/Makefile
	mv ../${PACKAGE}.zip ./dist

# target: zip-inte                               - Bundle a integration zip
zip-inte: ./vendor
	mkdir -p ./dist
	cp .env.inte.yml config/parameters.yml 2>/dev/null || echo "WARNING: no integration config file found";
	cd .. && zip -r ${PACKAGE}_integration.zip ${MODULE} -x '*.git*' -x '*.env*' \
	  ${MODULE}/dist/\* \
	  ${MODULE}/composer.phar \
	  ${MODULE}/Makefile
	mv ../${PACKAGE}_integration.zip ./dist

# target: build                                  - Setup PHP & Node.js locally
build: ./vendor

./vendor: composer.phar
	./composer.phar install --no-dev -o

composer.phar:
ifndef PHP
	$(error "PHP is unavailable on your system")
endif
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"

# target: tests                                  - Launch the tests and linting
tests: phpstan phpunit lint

# target: lint-back                              - Launch the back linting
lint:
	vendor/bin/php-cs-fixer fix --dry-run --diff --using-cache=no --diff-format udiff

# target: phpstan                                - Start phpstan
phpstan:
ifndef DOCKER
	$(error "DOCKER is unavailable on your system")
endif
	docker pull phpstan/phpstan:${PHPSTAN_VERSION}
	docker pull prestashop/prestashop:${PS_VERSION}
	docker run --rm -d -v ps-volume:/var/www/html --entrypoint /bin/sleep --name test-phpstan prestashop/prestashop:${PS_VERSION} 2s
	docker run --rm --volumes-from test-phpstan \
	  -v ${PWD}:/web/module \
	  -e _PS_ROOT_DIR_=/var/www/html \
	  --workdir=/web/module \
	  phpstan/phpstan:${PHPSTAN_VERSION} analyse \
	  --configuration=/web/module/tests/phpstan/${NEON_FILE}

# target: phpunit                                - Start phpunit
phpunit:
ifndef DOCKER
	$(error "DOCKER is unavailable on your system")
endif
	docker pull phpunit/phpunit:${PHPUNIT_VERSION}
	docker pull prestashop/prestashop:${PS_VERSION}
	docker run --rm -d -v ps-volume:/var/www/html --entrypoint /bin/sleep --name test-phpunit prestashop/prestashop:${PS_VERSION} 2s
	docker run --rm --volumes-from test-phpunit \
	  -v ${PWD}:/app:ro \
	  -v ${PWD}/vendor:/vendor:ro \
	  -e _PS_ROOT_DIR_=/var/www/html/ \
	  --workdir /app \
	  --entrypoint /vendor/phpunit/phpunit/phpunit \
	  phpunit/phpunit:${PHPUNIT_VERSION} \
	  --configuration ./phpunit.xml \
	  --bootstrap ./tests/unit/bootstrap.php
	@echo phpunit passed

# target: fix-lint                               - Launch php cs fixer and npm run lint
fix-lint: vendor/bin/php-cs-fixer
	vendor/bin/php-cs-fixer fix --using-cache=no

vendor/bin/php-cs-fixer:
	./composer.phar install

bps177: build-ps-177
ata177: all-tests-actions-177
rda177:run-docker-actions-177
du:docker-up

build-ps-177:
	-docker exec -i prestashop-177 sh -c "rm -rf /var/www/html/install"
	-docker exec -i prestashop-177 sh -c "mv /var/www/html/admin /var/www/html/admin1"
	mysql -h 127.0.0.1 -P 9001 --protocol=tcp -u root -pprestashop prestashop < $(shell pwd)/tests/System/Seed/Database/177.sql
	docker exec -i prestashop-177 sh -c "cd /var/www/html && php  bin/console prestashop:module install eventBus"

run-docker-actions-177:
	docker-compose up -d --force-recreate prestashop-177
	/bin/bash .docker/wait-for-container.sh sq-mysql

all-tests-actions-177:
	make rda177
	make bps177
	docker exec -i prestashop-177 sh -c "cd /var/www/html/modules/ps_eventbus && php vendor/bin/phpunit -c tests/phpunit-system.xml"

docker-up:
	docker-compose -f docker-compose.yml up
