#!/bin/sh
#
# This is an init-script for prestashop-flashlight.
#
# Storing a folder in /var/www/html/modules is not enough to register the module
# into PrestaShop, hence why we have to call the console install CLI.
#
set -eu

error() {
  printf "\e[1;31m%s\e[0m\n" "${1:-Unknown error}"
  exit "${2:-1}"
}

run_user() {
  sudo -g www-data -u www-data -- "$@"
}

ps_accounts_mock_install() {
  echo "* [ps_accounts_mock] downloading..."
  wget -q -O /tmp/ps_accounts.zip "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/0.0.0/ps_accounts.zip"
  echo "* [ps_accounts_mock] unziping..."
  run_user unzip -qq /tmp/ps_accounts.zip -d /var/www/html/modules
  echo "* [ps_accounts_mock] installing the module..."
  cd "$PS_FOLDER"
  run_user php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_accounts"
}

ps_eventbus_install() {
  MODULE_SRC="$PS_FOLDER/modules/ps_eventbus"
  [ ! -d "./modules/ps_eventbus/vendor" ] && error "please install composer dependencies first" 2
  find "$MODULE_SRC" -not -path "$MODULE_SRC/.git/*" -exec chown www-data:www-data {} \;
  echo "* [ps_eventbus] cleaning tools/vendor..."
  rm -rf "./modules/ps_eventbus/tools/vendor"
  echo "* [ps_eventbus] installing the module..."
  run_user php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"
}

ps_accounts_mock_install
ps_eventbus_install

