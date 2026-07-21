{**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 *}

{if !$LIVE_MODE_VUEJS}
  {if isset($eventbus_preload_urls)}
    {foreach from=$eventbus_preload_urls item=p}
      {if $p.rel == 'preload' && $p.as == 'style'}
        <link rel="preload" as="style" href="{$p.href|escape:'htmlall':'UTF-8'}">
      {/if}
    {/foreach}
  {/if}

  {if isset($eventbus_css_url) && $eventbus_css_url}
    <link rel="stylesheet" href="{$eventbus_css_url|escape:'htmlall':'UTF-8'}" type="text/css" media="all">
  {/if}
{/if}

{if $LIVE_MODE_VUEJS}
  <script type="module" src="http://localhost:5173/@vite/client"></script>
  <script type="module" src="http://localhost:5173/js/main.js"></script>
{else}
  {if isset($eventbus_preload_urls)}
    {foreach from=$eventbus_preload_urls item=p}
      {if $p.rel == 'modulepreload'}
        <link rel="modulepreload" href="{$p.href|escape:'htmlall':'UTF-8'}">
      {/if}
    {/foreach}
  {/if}

  <script type="module" src="{$eventbus_js_url|escape:'htmlall':'UTF-8'}"></script>
{/if}

<div id="vue-app"></div>
