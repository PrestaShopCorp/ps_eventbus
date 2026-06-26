#!/usr/bin/env bash
# Dump full-sync payloads for one ps_eventbus tag.
# Usage: run-version.sh <tag> [ps_image_tag]
#   ex:  run-version.sh v1.10.0 8.1.7
set -euo pipefail

TAG="${1:?tag required, e.g. v1.10.0}"
PS_IMAGE_TAG="${2:-8.1.7-7.4}"

REPO="$(cd "$(dirname "$0")/../.." && pwd)"
WORKTREES="$REPO/tools/dump/worktrees"
DUMPS="$REPO/tools/dump/dumps"
WORKTREE="$WORKTREES/$TAG"
LABEL="${DUMP_LABEL_OVERRIDE:-$TAG}"

LEGACY_CONTENTS=(
  apiCarriers apiCarts apiCategories apiCurrencies apiCustomers
  apiCustomProductCarriers apiGoogleTaxonomies apiInfo apiModules
  apiOrders apiProducts apiSpecificPrices apiThemes
)

# Unified controller appeared in main branch (post v1.11)
UNIFIED_CONTENTS=(
  bundles carriers carrier_details carrier_taxes carts cart_products cart_rules
  categories currencies customers custom_product_carriers employees
  images image_types info languages manufacturers modules
  order_carriers order_cart_rules order_details orders order_status_history
  products product_suppliers specific_prices stock_movements stocks
  stores suppliers taxonomies themes translations
  wishlists wishlist_products
)

mkdir -p "$WORKTREES" "$DUMPS"

echo "[*] Preparing worktree for $TAG"
if [ ! -d "$WORKTREE" ]; then
  git -C "$REPO" worktree add --force "$WORKTREE" "$TAG"
fi

if [ ! -f "$WORKTREE/.dump-prepared" ]; then
  echo "[*] composer install in worktree"
  ( cd "$WORKTREE" && composer install --no-dev --no-interaction --quiet )
  PREPARE=1
else
  PREPARE=0
fi

if [ "$PREPARE" = 1 ]; then
echo "[*] Patching config URLs"
PARAMS="$WORKTREE/config/parameters.yml"
CFG_PHP="$WORKTREE/config.php"
if [ -f "$PARAMS" ]; then
  sed -i \
    -e 's|ps_eventbus\.proxy_api_url:.*|ps_eventbus.proxy_api_url: "http://cloudsync-mock:3333"|' \
    -e 's|ps_eventbus\.sync_api_url:.*|ps_eventbus.sync_api_url: "http://cloudsync-mock:3232"|' \
    -e 's|ps_eventbus\.live_sync_api_url:.*|ps_eventbus.live_sync_api_url: "http://cloudsync-mock:3434"|' \
    "$PARAMS"
elif [ -f "$CFG_PHP" ]; then
  cat > "$CFG_PHP" <<'PHP'
<?php
return [
    'ps_eventbus.proxy_api_url' => 'http://cloudsync-mock:3333',
    'ps_eventbus.sync_api_url' => 'http://cloudsync-mock:3232',
    'ps_eventbus.live_sync_api_url' => 'http://cloudsync-mock:3434',
    'ps_eventbus.sentry_dsn' => 'https://sentry-id@stuff.ingest.sentry.io/stuff',
    'ps_eventbus.sentry_env' => 'dump',
];
PHP
else
  echo "!! no parameters.yml or config.php found" >&2
  exit 2
fi
touch "$WORKTREE/.dump-prepared"
fi

export DUMP_WORKTREE="$WORKTREE"
export DUMP_OUTPUT_DIR="$DUMPS"
export DUMP_LABEL="$LABEL"
export DOCKER_IMAGE_PRESTASHOP="prestashop/prestashop-flashlight:${PS_IMAGE_TAG}"
# avoid host port collisions with other local stacks
export HOST_PORT_BIND_PRESTASHOP=18000
export HOST_PORT_BIND_MYSQL=13306
export HOST_PORT_BIND_PHP_MY_ADMIN=16060
export HOST_PORT_BIND_CLOUDSYNC_REVERSE_PROXY=13030
export SYNC_API_PORT=13232
export COLLECTOR_API_PORT=13333
export LIVE_SYNC_API_PORT=13434
export WS_PORT=18081

ENV_FILE="$REPO/e2e-env/.env.dist"
COMPOSE=( docker compose
  --env-file "$ENV_FILE"
  -f "$REPO/e2e-env/docker-compose.yml"
  -f "$REPO/tools/dump/docker-compose.dump.yml"
  -p "ps_eventbus_dump_${DUMP_PROJECT_SUFFIX:-${TAG//[.\/]/_}}"
  --profile dump
)

cleanup() { "${COMPOSE[@]}" down -v --remove-orphans || true; }
trap cleanup EXIT

echo "[*] Bringing up stack (PS=$PS_IMAGE_TAG)"
"${COMPOSE[@]}" up -d cloudsync-mock mysql prestashop-dump

echo "[*] Waiting for prestashop-dump healthy"
for i in $(seq 1 60); do
  state=$("${COMPOSE[@]}" ps --format json prestashop-dump | grep -o '"Health":"[^"]*"' | head -1 || true)
  if echo "$state" | grep -q healthy; then break; fi
  sleep 5
done

PS_PORT="${HOST_PORT_BIND_PRESTASHOP}"
BASE="http://localhost:${PS_PORT}/index.php?fc=module&module=ps_eventbus"

echo "[*] Triggering full-sync controllers"
if [ -f "$WORKTREE/controllers/front/apiShopContent.php" ]; then
  for sc in "${UNIFIED_CONTENTS[@]}"; do
    job="valid-job-${sc}-$$"
    url="${BASE}&controller=apiShopContent&shop_content=${sc}&job_id=${job}&lang_iso=en&full=1&limit=50"
    echo "    -> $sc"
    code=$(curl -s -o /tmp/dump_resp_$$.json -w '%{http_code}' "$url" || true)
    echo "       HTTP $code"
  done
else
  for c in "${LEGACY_CONTENTS[@]}"; do
    job="valid-job-${c#api}-$$"
    url="${BASE}&controller=${c}&job_id=${job}&full=1&limit=50"
    echo "    -> $c"
    code=$(curl -s -o /tmp/dump_resp_$$.json -w '%{http_code}' "$url" || true)
    echo "       HTTP $code"
  done
fi
rm -f /tmp/dump_resp_$$.json

echo "[*] Done. Dumps under: $DUMPS/$LABEL"
ls -la "$DUMPS/$LABEL" || true
