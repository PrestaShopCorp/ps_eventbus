#!/usr/bin/env bash
# Cartesian dump: ps_eventbus tag x compatible PS major.
# Runs cells in parallel batches (PARALLEL env, default 4).
set -uo pipefail

HERE="$(cd "$(dirname "$0")" && pwd)"
REPO="$(cd "$HERE/../.." && pwd)"
PARALLEL="${PARALLEL:-4}"

PS17_IMAGE="1.7.8.11-7.4"
PS8_IMAGE="8.1.7-7.4"
PS9_IMAGE="9.0.3-debian-apache"

TAGS=$(git -C "$REPO" tag | grep -E "^v[1-4]\.[0-9]+\.[0-9]+$" | \
  awk -F'[v.]' '$2>1 || ($2==1 && $3>=8)' | sort -V)
TAGS="$TAGS main"

compat_majors() {
  case "$1" in
    v1.8.*|v1.9.*)   echo "ps1.7 ps8" ;;
    v1.10.*)         echo "ps1.7 ps8" ;;
    v2.*)            echo "ps8" ;;
    v3.*|v4.*|main)  echo "ps8 ps9" ;;
    *)               echo "" ;;
  esac
}

image_for() {
  case "$1" in
    ps1.7) echo "$PS17_IMAGE" ;;
    ps8)   echo "$PS8_IMAGE" ;;
    ps9)   echo "$PS9_IMAGE" ;;
  esac
}

SUMMARY="$HERE/dumps/_summary.txt"
JOBLIST="$HERE/dumps/_jobs.txt"
mkdir -p "$HERE/dumps"
: > "$SUMMARY"
: > "$JOBLIST"

# Build joblist: skip cells already populated
for TAG in $TAGS; do
  for PS in $(compat_majors "$TAG"); do
    IMG=$(image_for "$PS")
    LABEL="$PS/$TAG"
    SAFE_PS="${PS//./_}"
    SAFE_TAG="${TAG//[.\/-]/_}"
    SUFFIX="${SAFE_PS}_${SAFE_TAG}"
    if [ -d "$HERE/dumps/$LABEL" ] && [ "$(ls "$HERE/dumps/$LABEL" 2>/dev/null | wc -l)" -gt 0 ]; then
      n=$(ls "$HERE/dumps/$LABEL" | wc -l)
      echo "ok   $LABEL $n" >> "$SUMMARY"
      continue
    fi
    printf '%s\t%s\t%s\t%s\n' "$TAG" "$IMG" "$LABEL" "$SUFFIX" >> "$JOBLIST"
  done
done

NJOBS=$(wc -l < "$JOBLIST")
echo "[*] $NJOBS cells to run, parallelism=$PARALLEL"

run_one() {
  local TAG="$1" IMG="$2" LABEL="$3" SUFFIX="$4"
  local logf="$HERE/dumps/_log_${SUFFIX}.txt"
  if DUMP_LABEL_OVERRIDE="$LABEL" DUMP_PROJECT_SUFFIX="$SUFFIX" \
     "$HERE/run-version.sh" "$TAG" "$IMG" > "$logf" 2>&1; then
    local n=$(ls "$HERE/dumps/$LABEL" 2>/dev/null | wc -l)
    if [ "$n" -gt 0 ]; then
      echo "[ok]   $LABEL ($n files)"
      echo "ok   $LABEL $n" >> "$SUMMARY"
    else
      echo "[FAIL] $LABEL — 0 files ($logf)"
      echo "fail $LABEL 0files" >> "$SUMMARY"
    fi
  else
    echo "[FAIL] $LABEL — exit ($logf)"
    echo "fail $LABEL exit" >> "$SUMMARY"
  fi
}
slots=0
while IFS=$'\t' read -r TAG IMG LABEL SUFFIX; do
  while [ "$slots" -ge "$PARALLEL" ]; do wait -n; slots=$((slots-1)); done
  run_one "$TAG" "$IMG" "$LABEL" "$SUFFIX" &
  slots=$((slots+1))
done < "$JOBLIST"
wait

echo
echo "=== Summary ==="
sort -u "$SUMMARY" | tail -200
