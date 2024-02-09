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
  # Some explanations are required here:
  #
  # If you look closer to the ./docker-compose.yml prestashop service, you will
  # see multiple mounts on the same files:
  # - ..:/var/www/html/modules/ps_eventbus:rw        => mount all the sources
  # - /var/www/html/modules/ps_eventbus/vendor       => void the specific vendor dir, makint it empty
  # - /var/www/html/modules/ps_eventbus/tools/vendor => void the specific vendor dev dir, making it empty
  # 
  # That said, we now want our container to have RW access on these directories, 
  # and to install the required composer dependencies for the module to work.
  #
  # Other scenarios could be imagined, but this is the best way to avoid writes on a mounted volume,
  # which would not work on a Linux environment (binding a volume), as opposed to a Windows or Mac one (NFS mount).
  chown www-data:www-data ./modules/ps_eventbus/vendor
  chown www-data:www-data ./modules/ps_eventbus/tools/vendor
  run_user composer install -n -d ./modules/ps_eventbus

  echo "* [ps_eventbus] installing the module..."
  cd "$PS_FOLDER"
  run_user php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"
}

ps_accounts_mock_install
ps_eventbus_install

