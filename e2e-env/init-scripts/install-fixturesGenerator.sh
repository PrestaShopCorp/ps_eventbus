#!/bin/bash

cd modules/
git clone https://github.com/PrestaShop/ps_fixturescreator.git
cd ps_fixturescreator/
composer install
cd ../..
php bin/console prestashop:module install ps_fixturescreator
php bin/console cache:clear'
