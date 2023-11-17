#!/bin/bash
[ -z "$1" ] && {
  echo "Error: Please provide a path to apply this script. Example if you are at the root of the git project: $0 ./" >&2;
  exit 1;
}

SRC_DIR="$1/src"
CONFIG_DIR="$1/config"

SED_PARAMS=()
if [[ "$OSTYPE" == "darwin"* ]]; then
  SED_PARAMS+=(-i '')
else
  SED_PARAMS+=(-i)
fi

mkdir -p "$SRC_DIR/Mock"
cp "$(dirname "$0")/PsAccounts.php" "$SRC_DIR/Mock/PsAccounts.php"

# I could not just inject my PsAccounts mock with the "class" attribute in Yaml
# so dumb me thought: replace the naming everywhere it will work
find "$CONFIG_DIR" -type f -exec sed "${SED_PARAMS[@]}" -e 's/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/g' {} \;
find "$SRC_DIR" -type f -exec sed "${SED_PARAMS[@]}" -e 's/PrestaShop\\PsAccountsInstaller\\Installer\\Facade\\PsAccounts/PrestaShop\\Module\\PsEventbus\\Mock\\PsAccounts/g' {} \;

# Cheating here, I don't know how to mock the following:
#   $module = \Module::getInstanceByName('ps_accounts');
#   return $module->getService(AccountsClient::class);
# shellcheck disable=SC2016
sed "${SED_PARAMS[@]}" -e 's/=> $tokenValid/=> true/' "$SRC_DIR/Repository/ServerInformationRepository.php"
