#!/bin/bash
cd "$(dirname $0)"

SRC_DIR="../../src"
CONFIG_DIR="../../config"

SEDOPTION=
if [[ "$OSTYPE" == "darwin"* ]]; then
    SEDOPTION="-i ''"
else
    SEDOPTION="-i"
fi

rm -rf "$SRC_DIR/Mock"

find "$CONFIG_DIR" -type f -exec sed $SEDOPTION -e 's/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/g' {} \;
find "$SRC_DIR" -type f -exec sed $SEDOPTION -e 's/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/g' {} \;

# shellcheck disable=SC2016
sed $SEDOPTION -e 's/=> true/=> $tokenValid/' "$SRC_DIR/Repository/ServerInformationRepository.php"
