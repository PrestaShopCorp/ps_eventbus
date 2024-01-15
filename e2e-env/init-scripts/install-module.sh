#!/bin/sh
#
# This is an init-script for prestashop-flashlight.
#
# Storing a folder in /var/www/html/modules is not enough to register the module
# into PrestaShop, hence why we have to call the console install CLI.
#
set -eu

cd "$PS_FOLDER"
MODULE_SRC="$PS_FOLDER/modules/ps_eventbus"
find "$MODULE_SRC" -not -path "$MODULE_SRC/.git/*" -exec chown www-data:www-data {} \;

echo "* [ps_accounts_mock] downloading..."
wget -q -O /tmp/ps_accounts.zip "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/0.0.0/ps_accounts.zip"
echo "* [ps_accounts_mock] unziping..."
unzip -qq /tmp/ps_accounts.zip -d /var/www/html/modules
echo "* [ps_accounts_mock] installing the module..."
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_accounts"

echo "* [ps_eventbus] cleaning tools/vendor..."
rm -rf "./modules/ps_eventbus/tools/vendor"
echo "* [ps_eventbus] installing the module..."
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"
