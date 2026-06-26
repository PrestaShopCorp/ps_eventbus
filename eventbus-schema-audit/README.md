# ps_eventbus schema audit

Per-version inventory of shop content types exposed by `ps_eventbus` from
`1.0.0` → `v4.0.15`. Built by walking every stable git tag and listing the
type sources at that revision.

## Layout

- `<tag>.json` — raw per-tag dump (109 files, one per stable release)
- `_summary.json` — semver-ordered, normalized union of types per tag
- `_transitions.json` — added/removed types between consecutive releases

Stable tag filter: `^v?\d+\.\d+\.\d+$` (no alpha/beta/snapshot).

## Per-tag JSON shape

```json
{
  "tag": "v4.0.15",
  "api_controllers": ["bundles", "carriers", ...],
  "shop_content_services": ["Bundles", "Carriers", ...],
  "config_collections": ["bundles", "carrier_details", ...],
  "fields_by_type": {
    "cart": {
      "id_cart":    {"type": "string", "source": "select"},
      "created_at": {"type": "string", "source": "select"},
      "updated_at": {"type": "string", "source": "select"}
    },
    "carrier": {
      "active":              {"type": "bool",   "source": "select"},
      "grade":               {"type": "int",    "source": "select"},
      "max_weight":          {"type": "float",  "source": "select"},
      "carrier_taxes_rates_group_id": {"type": "string", "source": "derived"}
    }
  }
}
```

Field sources per tag:

| field | source files | versions present |
|---|---|---|
| `api_controllers` | `controllers/front/api*.php` basenames, `api` prefix stripped, lowercased | all |
| `shop_content_services` | `src/Service/ShopContent/*Service.php` class basenames, `Service` suffix stripped | v4+ |
| `config_collections` | `COLLECTION_* = '...'` consts in `src/Config/Config.php` | v2+ (populated v4+) |
| `fields_by_type` | `->select(...)` calls + `$row['x'] = (T) ...` casts in Repository / Service / api-controller files | all |

### `fields_by_type` details

- Key = canonical singular type stem (snake_case, naive depluralization;
  `carrier_taxe` → `carrier_tax` aliased). Lets `CartRepository`,
  `apiCarts`, `CartsService` collapse to `cart`.
- Value = `{field_name: {type, source}}`
- `type` ∈ `{int, float, bool, string, date, json}`
  - `string` is the default for any field appearing in `->select()` with no
    cast (PrestaShop returns DB rows as strings).
  - `int` / `float` / `bool` come from explicit `(int)` / `(float)` /
    `(bool)` PHP casts; `integer`/`double`/`boolean` normalized.
  - `date` triggered by `strtotime($row['x'])` or
    `$row['x'] = date(...)`.
  - `json` triggered by `$row['x'] = json_encode(...)`.
  - Specificity: `date > json > {int,float,bool} > string`.
- `source` ∈ `{select, derived}`
  - `select` = field appeared in a `->select()` (real DB column or alias).
  - `derived` = field set in PHP only, not in SELECT (computed at
    runtime, e.g. `price_per_unit`).
- Multi-field selects like `->select('a, b as c, t.d')` are split on
  top-level commas; field name is the alias (after ` as `), else the
  last `.`-segment, else the raw token.
- Repos excluded as infra: `Abstract`, `Interface`, `Sync`,
  `IncrementalSync`, `LiveSync`, `EventbusSync`, `DeletedObjects`,
  `Configuration`, `Country`. Controllers excluded: `apiHealthCheck`.

## Summary / transitions JSON shape

`_summary.json`:

```json
[{"tag": "v4.0.15", "types": ["bundles", "carriers", ...]}, ...]
```

`types` = union of the three source fields above, lowercased, underscores
stripped (e.g. `carrier_details` → `carrierdetails`, `OrderCarriers` →
`ordercarriers`). De-duped across sources.

`_transitions.json`:

```json
[{"tag": "v1.7.0", "added": ["carriers", ...], "removed": ["carrier", ...]}, ...]
```

Only releases where the set changed are listed.

## Caveats / known noise

Read these before drawing conclusions from the data:

- `shopcontent` / `shopcontentabstract` at `v4.0.0` are the base class +
  interface (`ShopContentAbstractService.php`, `ShopContentServiceInterface.php`),
  not real types. Filter out.
- `healthcheck`, `info`, `deletedobjects`, `deleted` are infra endpoints,
  not shop content. Same for `apiHealthCheck` controllers.
- Pluralization churn at `v1.7.0`: `carrier`→`carriers`, `specificprice`→
  `specificprices`, `customproductcarrier`→`customproductcarriers`. Looks
  like add/remove but is a rename.
- `googletaxonomies` (added `1.0.0`) was effectively renamed to
  `taxonomies` at `v1.6.4`; the old name finally drops at `v4.0.0`.
- `attributes`, `shops` drop at `v4.0.0` (architectural rewrite).
- Underscore stripping in `types` is for cross-version matching. To see
  exact canonical names (with underscores), read `config_collections` in
  the per-tag JSON instead of `_summary.json`.
- Type sets are derived from *file presence*, not runtime registration.
  A type file existing at a tag does not guarantee it was actually exposed
  / wired up in that release. Cross-check `Config.php` allowlist arrays
  (`SHOP_CONTENTS`, `INCREMENTAL_TYPES`) if certainty matters.
- `fields_by_type` is regex-based extraction; coverage ~80–90%. Misses:
  fields built via dynamic loops, casts spread across helper methods we
  don't follow, conditional types. Trust select-listed fields, treat
  derived ones as best-effort. If precision matters, parse the actual
  PHP at that revision.
- Pre-v4 controllers `api*.php` sometimes did casts in their `cast*()`
  helpers — captured. Pre-v4 repos that built SELECTs via array
  `implode(',', $cols)` rather than `->select()` chains are missed.

## Inflection points

- `v1.6.4` — big bang, +9 types (bundles, cart_products, order_details,
  taxonomies, specific_prices, custom_product_carriers, shops, deleted, …)
- `v1.10.x` — wishlists, cart_rules, stores, stocks, stock_movements rolled
  out across patch releases
- `v2.3.0` — manufacturers/suppliers added
- `v3.0.0` — i18n/media: employees, images, image_types, translations
- `v4.0.0` — architectural rewrite. Drops 5 legacy types (incl.
  `googletaxonomies`, `attributes`, `shops`), introduces
  `Service/ShopContent` layer + `Config::COLLECTION_*` registry. +2 real
  types (`carrier_details`, `carrier_taxes`)
- `v4.0.2` — `order_carriers` added

## Scripts

- `extract_fields.py` — per-tag field+type extractor. Run as
  `python3 eventbus-schema-audit/extract_fields.py <tag>` from repo root,
  emits `{tag, fields_by_type}` JSON on stdout.

## Rebuild

From repo root:

```sh
mkdir -p eventbus-schema-audit
for t in $(git tag | grep -E '^v?[0-9]+\.[0-9]+\.[0-9]+$' | sort -V); do
  ctrls=$(git ls-tree -r --name-only "$t" 2>/dev/null \
    | grep -E '^controllers/front/api[A-Z][^/]*\.php$' \
    | sed -E 's|controllers/front/api||; s|\.php$||' \
    | tr 'A-Z' 'a-z' | sort -u | jq -R . | jq -s .)
  svcs=$(git ls-tree -r --name-only "$t" 2>/dev/null \
    | grep -E '^src/Service/ShopContent/[A-Z][^/]*Service\.php$' \
    | sed -E 's|.*/||; s|Service\.php$||' \
    | sort -u | jq -R . | jq -s .)
  collections=$(git show "$t":src/Config/Config.php 2>/dev/null \
    | grep -oE "COLLECTION_[A-Z_]+ = '[a-z_]+'" \
    | sed -E "s/.*= '([a-z_]+)'/\1/" \
    | sort -u | jq -R . | jq -s .)
  jq -n --arg tag "$t" --argjson ctrls "$ctrls" \
        --argjson svcs "$svcs" --argjson cols "$collections" \
        '{tag:$tag, api_controllers:$ctrls,
          shop_content_services:$svcs, config_collections:$cols}' \
    > "eventbus-schema-audit/$t.json"
done

# semver-ordered summary
( for t in $(git tag | grep -E '^v?[0-9]+\.[0-9]+\.[0-9]+$' | sort -V); do
    cat "eventbus-schema-audit/$t.json"
  done
) | jq -s 'map({tag, types: (.api_controllers + .shop_content_services
        + .config_collections | map(ascii_downcase | gsub("_";"")) | unique)})' \
    > eventbus-schema-audit/_summary.json

# augment with fields_by_type
for t in $(git tag | grep -E '^v?[0-9]+\.[0-9]+\.[0-9]+$' | sort -V); do
  python3 eventbus-schema-audit/extract_fields.py "$t" > /tmp/f.json
  jq 'del(.fields_by_type)' "eventbus-schema-audit/$t.json" > /tmp/b.json
  jq -s '.[0] * .[1]' /tmp/b.json /tmp/f.json > "eventbus-schema-audit/$t.json"
done
rm -f /tmp/f.json /tmp/b.json

# transitions
jq '
  . as $all
  | reduce range(0;length) as $i ({prev:[], out:[]};
      .out += [{
        tag: $all[$i].tag,
        added:   ($all[$i].types - .prev),
        removed: (.prev - $all[$i].types)
      }]
      | .prev = $all[$i].types)
  | .out
  | map(select(.added!=[] or .removed!=[]))
' eventbus-schema-audit/_summary.json > eventbus-schema-audit/_transitions.json
```

## Scope this audit does NOT cover

User asked for "shop content types list" only. Out of scope:

- Per-type SELECT columns / row shape
- Formatter casts (int / float / bool / date)
- Incremental-sync vs full-sync allowlist
- Live-sync registry
- Module / table version per release

Extend `<tag>.json` if needed: parse `Repository/*Repository.php` for
`->select(...)` calls and `Formatter/*.php` for cast maps.
