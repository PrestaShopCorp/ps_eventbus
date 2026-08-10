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

ps_eventbus_install() {
  # Notice: you might enable this if your uid is not 1000, or encounter permission issues
  # composer install -n -d ./modules/ps_eventbus
  cd "$PS_FOLDER"

  # Detect PS version to choose the right CLI syntax.
  # PS 1.6 flashlight ships a polyfill bin/console that only understands
  # "prestashop:module install <name>" (no --no-interaction, no uninstall).
  PS_VERSION=$(php -r "
    @include 'config/defines.inc.php';
    @include 'config/settings.inc.php';
    if (defined('_PS_VERSION_')) { echo _PS_VERSION_; }
    elseif (file_exists('app/AppKernel.php')) { echo '8.0.0'; }
    else { echo '1.6.0'; }
  ")
  IS_16=$(php -r "echo version_compare('$PS_VERSION', '1.7', '<') ? '1' : '0';")

  if [ "$IS_16" = "1" ]; then
    echo "* [ps_eventbus] PS $PS_VERSION detected — installing module..."
    php -d memory_limit=-1 bin/console prestashop:module install ps_eventbus
  else
    # Some flashlight images ship ps_eventbus pre-installed with a stale schema
    # (e.g. missing last_seek_key). Uninstall first so install.sql runs fresh.
    echo "* [ps_eventbus] uninstalling any pre-baked version..."
    php -d memory_limit=-1 bin/console prestashop:module --no-interaction uninstall "ps_eventbus" || true
    echo "* [ps_eventbus] installing the module..."
    php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"
  fi
}

ps_eventbus_install
