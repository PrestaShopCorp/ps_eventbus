#!/usr/local/bin/php
<?php
echo "* Starting webservice configuration...\n";

require('/var/www/html/config/config.inc.php');
Configuration::updateValue('PS_WEBSERVICE', 1);

$apiAccess = new WebserviceKey();
$apiAccess->key = 'GENERATE_A_COMPLEX_VALUE_WITH_32';
$apiAccess->save();

$permissions = [
  'carriers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'carts' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'cart_rules' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'categories' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'combinations' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'configurations' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'currencies' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'customers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'languages' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'images' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'image_types' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_carriers' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_cart_rules' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_details' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_histories' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_invoices' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_payments' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_slip' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'order_states' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'orders' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'products' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'product_features' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'product_feature_values' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'product_options' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'product_option_values' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'specific_prices' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'stores' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'stock_availables' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'tax_rule_groups' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'tax_rules' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
  'taxes' => ['GET' => 1, 'POST' => 1, 'PUT' => 1, 'PATCH' => 1, 'DELETE' => 1, 'HEAD' => 1],
];

echo "* Add key permission for webservice...\n";

WebserviceKey::setPermissionForAccount($apiAccess->id, $permissions);
