#!/bin/sh
# As the module sources are directly mounted within prestashop-flashlight
# it is useful to call some cleaning and manual installation scripts
set -eu

cd "$PS_FOLDER"
rm -rf "./modules/ps_eventbus/tools/vendor"
php -d memory_limit=-1 bin/console prestashop:module --no-interaction install "ps_eventbus"
                                                   