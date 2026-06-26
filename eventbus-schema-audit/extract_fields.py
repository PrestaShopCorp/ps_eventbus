#!/usr/bin/env python3
"""Extract per-type field+type map from a ps_eventbus git tag.

Output JSON to stdout:
  {
    "tag": "v4.0.15",
    "fields_by_type": {
      "cart": {
        "id_cart":    {"type": "int",    "source": "cast"},
        "created_at": {"type": "date",   "source": "select"},
        ...
      },
      ...
    }
  }

Sources scanned per tag:
  - src/Repository/*Repository.php   -> ->select(...) lines
  - src/Service/ShopContent/*Service.php (v4+) -> ->select + cast lines
  - controllers/front/api*.php       -> ->select + cast lines (pre-v4)

Type stems normalized via `canonical()` (snake_case, naive depluralization)
so CartRepository.php + apiCarts.php + CartsService.php all collapse to `cart`.
"""
import json
import re
import subprocess
import sys

TAG = sys.argv[1]

SELECT_RE = re.compile(r"->\s*(?:add)?[Ss]elect\s*\(\s*['\"]([^'\"]+)['\"]")
AS_RE = re.compile(r"\s+as\s+([A-Za-z_][A-Za-z_0-9]*)\s*$", re.IGNORECASE)
CAST_RE = re.compile(
    r"\$\w+\[\s*['\"]([A-Za-z_][A-Za-z_0-9]*)['\"]\s*\]"
    r"\s*=\s*\(\s*(int|float|bool|string|double|integer|boolean)\s*\)"
)
DATE_STRTOTIME_RE = re.compile(
    r"strtotime\s*\(\s*\$\w+\[\s*['\"]([A-Za-z_][A-Za-z_0-9]*)['\"]\s*\]"
)
DATE_ASSIGN_RE = re.compile(
    r"\$\w+\[\s*['\"]([A-Za-z_][A-Za-z_0-9]*)['\"]\s*\]"
    r"\s*=\s*date\s*\("
)
JSON_RE = re.compile(
    r"\$\w+\[\s*['\"]([A-Za-z_][A-Za-z_0-9]*)['\"]\s*\]"
    r"\s*=\s*json_encode\s*\("
)

PHP_TYPE_NORMALIZE = {
    "integer": "int",
    "double": "float",
    "boolean": "bool",
}

# Specificity: higher wins on conflict
TYPE_RANK = {"string": 1, "int": 2, "float": 2, "bool": 2, "json": 3, "date": 4}


def ls(tag):
    return subprocess.run(
        ["git", "ls-tree", "-r", "--name-only", tag],
        capture_output=True, text=True, check=True,
    ).stdout.splitlines()


def show(tag, path):
    r = subprocess.run(
        ["git", "show", f"{tag}:{path}"],
        capture_output=True, text=True,
    )
    return r.stdout if r.returncode == 0 else ""


def camel_to_snake(s):
    return re.sub(r"(?<!^)(?=[A-Z])", "_", s).lower()


ALIAS = {
    "carrier_taxe": "carrier_tax",  # repo uses french-style "taxe"
}


def canonical(stem):
    s = camel_to_snake(stem)
    parts = s.split("_")
    last = parts[-1]
    if last.endswith("ies") and len(last) > 3:
        parts[-1] = last[:-3] + "y"
    elif last.endswith("ses") and len(last) > 3:
        parts[-1] = last[:-2]
    elif last.endswith("xes") and len(last) > 3:
        parts[-1] = last[:-2]
    elif last.endswith("s") and not last.endswith("ss") and len(last) > 1:
        parts[-1] = last[:-1]
    out = "_".join(parts)
    return ALIAS.get(out, out)


INFRA_REPOS = {
    "AbstractRepository.php",
    "RepositoryInterface.php",
    "SyncRepository.php",
    "IncrementalSyncRepository.php",
    "LiveSyncRepository.php",
    "EventbusSyncRepository.php",
    "DeletedObjectsRepository.php",
    "ConfigurationRepository.php",
    "CountryRepository.php",
}


def type_from_repo(basename):
    return canonical(basename[: -len("Repository.php")])


def type_from_service(basename):
    return canonical(basename[: -len("Service.php")])


def type_from_controller(basename):
    return canonical(basename[len("api"): -len(".php")])


def _split_top_commas(s):
    """Split on commas not nested inside parens."""
    depth = 0
    buf = []
    parts = []
    for ch in s:
        if ch == "(":
            depth += 1
        elif ch == ")":
            depth -= 1
        if ch == "," and depth == 0:
            parts.append("".join(buf))
            buf = []
        else:
            buf.append(ch)
    if buf:
        parts.append("".join(buf))
    return [p.strip() for p in parts if p.strip()]


def extract_selects(content):
    out = []
    seen = set()
    for m in SELECT_RE.finditer(content):
        body = m.group(1).strip()
        for piece in _split_top_commas(body):
            raw = piece
            if raw.startswith("(") and raw.endswith(")"):
                raw = raw[1:-1].strip()
            am = AS_RE.search(raw)
            if am:
                name = am.group(1)
            elif "." in raw:
                name = raw.rsplit(".", 1)[-1]
            else:
                name = raw
            name = name.strip("`\"' ")
            if not re.match(r"^[A-Za-z_][A-Za-z_0-9]*$", name):
                continue
            if name in seen:
                continue
            seen.add(name)
            out.append(name)
    return out


def extract_casts(content):
    """Return dict: field -> php_type"""
    out = {}
    for m in CAST_RE.finditer(content):
        f, t = m.group(1), m.group(2)
        t = PHP_TYPE_NORMALIZE.get(t, t)
        # Specificity check vs prior cast on same field
        if f in out and TYPE_RANK.get(out[f], 0) >= TYPE_RANK.get(t, 0):
            continue
        out[f] = t
    for m in JSON_RE.finditer(content):
        out[m.group(1)] = "json"
    for m in DATE_STRTOTIME_RE.finditer(content):
        out[m.group(1)] = "date"
    for m in DATE_ASSIGN_RE.finditer(content):
        f = m.group(1)
        # don't downgrade an existing more specific type unless date wins
        out[f] = "date"
    return out


def merge(target, t_stem, fields, source_label, cast_map):
    """fields: list of names from selects. cast_map: name->type."""
    bucket = target.setdefault(t_stem, {})
    for f in fields:
        bucket.setdefault(f, {"type": "string", "source": "select"})
    for f, ph in cast_map.items():
        cur = bucket.get(f)
        if cur is None:
            bucket[f] = {"type": ph, "source": "derived"}
        else:
            # Upgrade type if cast more specific than current default
            if TYPE_RANK.get(ph, 0) > TYPE_RANK.get(cur["type"], 0):
                cur["type"] = ph
            # Keep first-seen source unless we discovered it via cast only
            if cur["source"] == "select":
                pass  # already in selects, cast just refines type
    # Annotate which sources contributed (debug)
    target.setdefault(f"__sources__::{t_stem}", set()).add(source_label)


def main():
    paths = ls(TAG)
    repo_files = [p for p in paths if re.match(r"^src/Repository/[A-Z][A-Za-z0-9]*Repository\.php$", p)]
    svc_files  = [p for p in paths if re.match(r"^src/Service/ShopContent/[A-Z][A-Za-z0-9]*Service\.php$", p)]
    ctrl_files = [p for p in paths if re.match(r"^controllers/front/api[A-Z][A-Za-z0-9]*\.php$", p)]

    fields_by_type = {}

    for p in repo_files:
        base = p.rsplit("/", 1)[-1]
        if base in INFRA_REPOS:
            continue
        t = type_from_repo(base)
        c = show(TAG, p)
        selects = extract_selects(c)
        casts = extract_casts(c)
        if selects or casts:
            merge(fields_by_type, t, selects, "repository", casts)

    for p in svc_files:
        base = p.rsplit("/", 1)[-1]
        if base in ("ShopContentAbstractService.php", "ShopContentServiceInterface.php"):
            continue
        t = type_from_service(base)
        c = show(TAG, p)
        selects = extract_selects(c)
        casts = extract_casts(c)
        if selects or casts:
            merge(fields_by_type, t, selects, "service", casts)

    for p in ctrl_files:
        base = p.rsplit("/", 1)[-1]
        # skip infra
        if base in ("apiHealthCheck.php",):
            continue
        t = type_from_controller(base)
        c = show(TAG, p)
        selects = extract_selects(c)
        casts = extract_casts(c)
        if selects or casts:
            merge(fields_by_type, t, selects, "controller", casts)

    # Strip debug source sets
    clean = {k: v for k, v in fields_by_type.items() if not k.startswith("__sources__::")}
    # Sort fields alphabetically within each type
    clean = {
        t: dict(sorted(fmap.items()))
        for t, fmap in sorted(clean.items())
    }

    print(json.dumps({"tag": TAG, "fields_by_type": clean}, indent=2))


if __name__ == "__main__":
    main()
