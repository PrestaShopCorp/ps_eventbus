#!/bin/sh
set -eu
cd "$(dirname $0)" || exit 1

echo "* [ps_accounts_mock] downloading..."
echo "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/${PS_ACCOUNTS_MOCK_VERSION}/ps_accounts_mock-${PS_ACCOUNTS_MOCK_VERSION:1}.zip"
wget -q -O /tmp/ps_accounts.zip "https://github.com/PrestaShopCorp/ps_accounts_mock/releases/download/${PS_ACCOUNTS_MOCK_VERSION}/ps_accounts_mock-${PS_ACCOUNTS_MOCK_VERSION:1}.zip"
echo "* [ps_accounts_mock] unziping..."
unzip -qq /tmp/ps_accounts.zip -d /var/www/html/modules
echo "* [ps_accounts_mock] installing the module..."
cd "$PS_FOLDER"
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_accounts"
