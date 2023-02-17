#!/bin/bash
set -e

# see https://devdocs.prestashop.com/1.7/development/components/console/prestashop-module/
# see https://devdocs.prestashop.com/1.7/modules/testing/resources/
INSTALL_COMMAND="/var/www/html/bin/console prestashop:module --no-interaction install"
MODULES_DIRECTORY=/ps-modules

for file in $(ls ${MODULES_DIRECTORY}/*.zip); do
  module=$(basename ${file} | tr "-" "\n" | head -n 1);
  echo "--> installing ${module} from ${file}...";
  rm -rf "/var/www/html/modules/${module:-something-at-least}"
  unzip -qq ${file} -d /var/www/html/modules
  php $INSTALL_COMMAND ${module}
done;

# Hacky stuff
chown -R www-data:www-data /var/www/html
