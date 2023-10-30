#!/bin/bash
cd "$(dirname $0)"

SRC_DIR="../../src"
CONFIG_DIR="../../config"

rm -rf "$SRC_DIR/Mock"

find "$CONFIG_DIR" -type f -exec sed -i '' -e 's/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/g' {} \;
find "$SRC_DIR" -type f -exec sed -i '' -e 's/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/g' {} \;

# shellcheck disable=SC2016
sed -i '' -e 's/=> true/=> $tokenValid/' "$SRC_DIR/Repository/ServerInformationRepository.php"