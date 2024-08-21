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

ps_accounts_mock_install() {
  echo "* [ps_accounts_mock] downloading..."
  PS_ACCOUNTS_MOCK_VERSION="v7.0.2"
  echo "* [ps_accounts_mock] downloading..."
  wget -q -O /tmp/ps_accounts.zip "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/${PS_ACCOUNTS_MOCK_VERSION}/ps_accounts_mock-${PS_ACCOUNTS_MOCK_VERSION}.zip"
  echo "* [ps_accounts_mock] unziping..."
  unzip -qq /tmp/ps_accounts.zip -d /var/www/html/modules
  echo "* [ps_accounts_mock] installing the module..."
  cd "$PS_FOLDER"
  php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_accounts"
}

ps_eventbus_install() {
  # Notice: you might enable this if your uid is not 1000, or encounter permission issues
  # composer install -n -d ./modules/ps_eventbus
  echo "* [ps_eventbus] installing the module..."
  cd "$PS_FOLDER"
  php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"
}

ps_accounts_mock_install
ps_eventbus_install

