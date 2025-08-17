#!/bin/sh
set -eu
cd "$(dirname $0)" || exit 1

# Download and install the module's zip
echo "* [ps_eventbus] downloading..."
wget -q -O /tmp/ps_eventbus.zip "https://github.com/PrestaShopCorp/ps_eventbus/releases/download/${PS_EVENTBUS_VERSION}/ps_eventbus-${PS_EVENTBUS_VERSION}.zip"
echo "* [ps_eventbus] unziping..."
unzip -qq /tmp/ps_eventbus.zip -d /var/www/html/modules
echo "* [ps_eventbus] installing the module..."
cd "$PS_FOLDER"
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"

# Override the default parameters with the E2E settings
wget -O "/var/www/html/modules/ps_eventbus/config/parameters.yml" \
  "https://raw.githubusercontent.com/PrestaShopCorp/ps_eventbus/main/config/parameters.yml"
