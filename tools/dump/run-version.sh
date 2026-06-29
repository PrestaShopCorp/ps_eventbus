#!/usr/bin/env bash
# Dump full-sync payloads for one ps_eventbus tag.
# Usage: run-version.sh <tag> [ps_image_tag]
#   ex:  run-version.sh v1.10.0 8.1.7
# Self-contained: no host port bindings, curls run inside the container.
# Safe to run many instances in parallel — each instance uses a unique compose project.
set -euo pipefail

TAG="${1:?tag required, e.g. v1.10.0}"
PS_IMAGE_TAG="${2:-8.1.7-7.4}"

REPO="$(cd "$(dirname "$0")/../.." && pwd)"
HERE="$REPO/tools/dump"
WORKTREES="$HERE/worktrees"
DUMPS="$HERE/dumps"
WORKTREE="$WORKTREES/$TAG"
LABEL="${DUMP_LABEL_OVERRIDE:-$TAG}"

LEGACY_CONTENTS=(
  apiCarriers apiCarts apiCategories apiCurrencies apiCustomers
  apiCustomProductCarriers apiGoogleTaxonomies apiInfo apiModules
  apiOrders apiProducts apiSpecificPrices apiThemes
)

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

# Worktree prep is shared; guard with a flock to avoid races between parallel cells on the same tag.
echo "[$LABEL] preparing worktree"
(
  flock -x 9
  if [ ! -d "$WORKTREE" ]; then
    git -C "$REPO" worktree add --force "$WORKTREE" "$TAG"
  fi
  if [ ! -f "$WORKTREE/.dump-prepared" ]; then
    ( cd "$WORKTREE" && composer install --no-dev --no-interaction --quiet )
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
) 9>"$WORKTREES/.lock-${TAG//[.\/]/_}"

export DUMP_WORKTREE="$WORKTREE"
export DUMP_OUTPUT_DIR="$DUMPS"
export DUMP_LABEL="$LABEL"
export DOCKER_IMAGE_PRESTASHOP="prestashop/prestashop-flashlight:${PS_IMAGE_TAG}"

PROJECT="ps_eventbus_dump_${DUMP_PROJECT_SUFFIX:-${TAG//[.\/]/_}}"
COMPOSE=( docker compose
  -f "$HERE/docker-compose.dump.yml"
  -p "$PROJECT"
)

cleanup() { "${COMPOSE[@]}" down -v --remove-orphans >/dev/null 2>&1 || true; }
trap cleanup EXIT

echo "[$LABEL] up (PS=$PS_IMAGE_TAG)"
"${COMPOSE[@]}" up -d --quiet-pull >/dev/null

echo "[$LABEL] waiting healthy"
for i in $(seq 1 120); do
  state=$("${COMPOSE[@]}" ps --format json prestashop-dump 2>/dev/null | grep -o '"Health":"[^"]*"' | head -1 || true)
  if echo "$state" | grep -q healthy; then break; fi
  if echo "$state" | grep -q unhealthy; then echo "[$LABEL] unhealthy" >&2; break; fi
  sleep 5
done

PS_CON=$(docker ps -q --filter "label=com.docker.compose.project=$PROJECT" --filter "label=com.docker.compose.service=prestashop-dump")
if [ -z "$PS_CON" ]; then echo "[$LABEL] no PS container" >&2; exit 3; fi

echo "[$LABEL] trigger"
if [ -f "$WORKTREE/controllers/front/apiShopContent.php" ]; then
  for sc in "${UNIFIED_CONTENTS[@]}"; do
    job="valid-job-${sc}-$$"
    url="http://localhost/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=${sc}&job_id=${job}&lang_iso=en&full=1&limit=50"
    code=$(docker exec "$PS_CON" sh -c "curl -s -o /dev/null -w '%{http_code}' '$url'" || true)
    echo "[$LABEL]   $sc HTTP $code"
  done
else
  for c in "${LEGACY_CONTENTS[@]}"; do
    job="valid-job-${c#api}-$$"
    url="http://localhost/index.php?fc=module&module=ps_eventbus&controller=${c}&job_id=${job}&full=1&limit=50"
    code=$(docker exec "$PS_CON" sh -c "curl -s -o /dev/null -w '%{http_code}' '$url'" || true)
    echo "[$LABEL]   $c HTTP $code"
  done
fi

n=$(ls "$DUMPS/$LABEL" 2>/dev/null | wc -l)
echo "[$LABEL] done $n files"
