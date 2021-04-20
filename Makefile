.PHONY: clean help build bundle zip version bundle-prod bundle-inte build-back
PHP = $(shell which php 2> /dev/null)
DOCKER = $(shell docker ps 2> /dev/null)
NPM = $(shell which npm 2> /dev/null)
YARN = $(shell which yarn 2> /dev/null)
VERSION ?= $(shell git describe --tags)

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

# target: dist                                   - A directory to save zip bundles
dist:
	mkdir -p ./dist

# target: zip                                    - Make zip bundles
zip: zip-prod zip-inte

# target: zip-prod                               - Bundle a production zip
zip-prod: dist ./vendor
	cp .env.dist .env
	cd .. && zip -r ${PACKAGE}.zip ${MODULE} -x '*.git*' \
	  ${MODULE}/dist/\* \
	  ${MODULE}/composer.phar \
	  ${MODULE}/Makefile
	mv ../${PACKAGE}.zip ./dist

# target: zip-inte                               - Bundle a integration zip
zip-inte: dist ./vendor
	cp .env.inte .env
	cd .. && zip -r ${PACKAGE}_integration.zip ${MODULE} -x '*.git*' \
	  ${MODULE}/dist/\* \
	  ${MODULE}/composer.phar \
	  ${MODULE}/Makefile
	mv ../${PACKAGE}_integration.zip ./dist
	rm -f .env

# target: build                                  - Setup PHP & Node.js locally
build: ./vendor

./vendor: composer.phar
	./composer.phar install --no-dev -o

composer.phar:
ifndef PHP
	$(error "PHP is unavailable on your system")
endif
	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
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
