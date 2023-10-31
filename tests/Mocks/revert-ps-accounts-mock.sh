#!/bin/bash
cd "$(dirname "$0")" || exit 1

SRC_DIR="../../src"
CONFIG_DIR="../../config"

SED_PARAMS=()
if [[ "$OSTYPE" == "darwin"* ]]; then
  SED_PARAMS+=(-i '')
else
  SED_PARAMS+=(-i)
fi

rm -rf "$SRC_DIR/Mock"

find "$CONFIG_DIR" -type f -exec sed "${SED_PARAMS[@]}" -e 's/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/g' {} \;
find "$SRC_DIR" -type f -exec sed "${SED_PARAMS[@]}" -e 's/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/g' {} \;

# shellcheck disable=SC2016
sed "${SED_PARAMS[@]}" -e 's/=> true/=> $tokenValid/' "$SRC_DIR/Repository/ServerInformationRepository.php"
