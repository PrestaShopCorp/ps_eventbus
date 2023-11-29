#!/bin/sh
# As the module sources are directly mounted within prestashop-flashlight
# it is useful to call some cleaning and manual installation scripts
set -eu

cd "$PS_FOLDER"
echo "* [ps_eventbus] cleaning tools/vendor..."
rm -rf "./modules/ps_eventbus/tools/vendor"
echo "* [ps_eventbus] installing the module..."
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"

cp -r /tmp/init-scripts/ps_accounts ./modules/
cd ./modules/ps_accounts
echo "* [ps_accounts_mock] composer build..."
composer dump-autoload;
echo "* [ps_accounts_mock] installing the module..."
cd "$PS_FOLDER"
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_accounts"
