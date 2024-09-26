<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

global $_MODULE;
$_MODULE = array();
$_MODULE['<{ps_eventbus}prestashop>ps_eventbus_5aa8d80fbd2c1cd4eb908ed27db0e4f2'] = 'PrestaShop EventBus';
$_MODULE['<{ps_eventbus}prestashop>ps_eventbus_0bbed937e62f35ae2559105379b17bf4'] = 'El módulo complementario se implementa automáticamente cuando se instalan varios módulos en tu tienda PrestaShop. PrestaShop EventBus posibilita la sincronización de los datos técnicos y no personales entre tu tienda y estos servicios. Desinstalar PrestaShop EventBus puede hacer que estos módulos se bloqueen o incluso dejen de funcionar completamente.';
$_MODULE['<{ps_eventbus}prestashop>ps_eventbus_30c89345c4e1973a37ca5bb6bce30bb5'] = 'Esta acción impedirá inmediatamente el funcionamiento de sus servicios PrestaShop y servicios comunitarios, ya que están utilizando PrestaShop CloudSync para la sincronización.';
$_MODULE['<{ps_eventbus}prestashop>ps_eventbus_7af5fd6043aa260000f5238cd30ab2ed'] = 'Esto requiere PHP 7.1 para funcionar correctamente. Por favor, actualice la configuración de su servidor.';
