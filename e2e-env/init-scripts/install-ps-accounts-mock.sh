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
  PS_ACCOUNTS_MOCK_VERSION="v8.0.18"
  echo "* [ps_accounts_mock] downloading ${PS_ACCOUNTS_MOCK_VERSION}..."
  wget -q -O /tmp/ps_accounts.zip "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/${PS_ACCOUNTS_MOCK_VERSION}/ps_accounts_mock-${PS_ACCOUNTS_MOCK_VERSION}.zip"
  cd "$PS_FOLDER"

  if php -d memory_limit=-1 bin/console prestashop:module --no-interaction uninstall "ps_accounts" > /dev/null 2>&1; then
    echo "* [ps_accounts_mock] uninstalled the pre-installed ps_accounts"
  fi

  echo "* [ps_accounts_mock] unziping..."
  rm -rf "$PS_FOLDER/modules/ps_accounts"
  unzip -qq -o /tmp/ps_accounts.zip -d "$PS_FOLDER/modules"
  echo "* [ps_accounts_mock] installing the module..."
  php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_accounts"
}

ps_accounts_mock_install
