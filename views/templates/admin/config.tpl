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
