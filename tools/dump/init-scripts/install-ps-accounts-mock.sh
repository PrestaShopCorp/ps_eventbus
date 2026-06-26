#!/bin/sh
# Install ps_accounts_mock, overwriting any preinstalled real ps_accounts
# (PS 9 ships with ps_accounts preinstalled — we must replace it with the mock).
set -eu

PS_ACCOUNTS_MOCK_VERSION="v7.0.2"

cd "$PS_FOLDER"

if php -d memory_limit=-1 bin/console prestashop:module list 2>/dev/null | grep -q '^ps_accounts'; then
  echo "* [ps_accounts] uninstalling preinstalled module"
  php -d memory_limit=-1 bin/console prestashop:module --no-interaction uninstall ps_accounts || true
fi
rm -rf "$PS_FOLDER/modules/ps_accounts"

echo "* [ps_accounts_mock] downloading $PS_ACCOUNTS_MOCK_VERSION"
wget -q -O /tmp/ps_accounts.zip \
  "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/${PS_ACCOUNTS_MOCK_VERSION}/ps_accounts_mock-${PS_ACCOUNTS_MOCK_VERSION}.zip"
unzip -qq /tmp/ps_accounts.zip -d "$PS_FOLDER/modules"

echo "* [ps_accounts_mock] installing"
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install ps_accounts
