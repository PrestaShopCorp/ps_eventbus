<?php

return [
    'ps_eventbus.proxy_api_url' => 'http://reverse-proxy/collector',
    'ps_eventbus.eventbus_sync_api_url' => 'http://reverse-proxy/sync-api',
    'ps_eventbus.cloudsync_live_sync_api_url' => 'http://reverse-proxy/live-sync-api/v1',
    'ps_eventbus.cloudsync_sync_api_url' => 'http://reverse-proxy/sync-api',
    'ps_eventbus.cloudsync_reporting_api_url' => 'http://reverse-proxy/reporting-api',
    'ps_eventbus.sentry_dsn' => 'https://sentry-id@stuff.ingest.sentry.io/stuff',
    'ps_eventbus.sentry_env' => 'development',
    'ps_eventbus.live_mode_vuejs' => true,
];
