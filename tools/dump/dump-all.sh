#!/usr/bin/env bash
# Cartesian dump: every ps_eventbus tag 1.8+ x compatible PrestaShop majors.
# Output: tools/dump/dumps/<ps_major>/<tag>/<shopContent>-<ts>.ndjson
set -uo pipefail

HERE="$(cd "$(dirname "$0")" && pwd)"
REPO="$(cd "$HERE/../.." && pwd)"

PS17_IMAGE="1.7.8.11-7.4"
PS8_IMAGE="8.1.7-7.4"
PS9_IMAGE="9.0.3-debian-apache"

# all GA tags 1.8.0+ sorted
TAGS=$(git -C "$REPO" tag | grep -E "^v1\.([89]|1[0-9])\.[0-9]+$" | sort -V)
TAGS="$TAGS main"

compat_majors() {
  case "$1" in
    v1.8.*|v1.9.*)        echo "ps1.7" ;;
    v1.10.*)              echo "ps1.7 ps8" ;;
    v1.11.*|v1.12.*|main) echo "ps8 ps9" ;;
    *)                    echo "" ;;
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
mkdir -p "$HERE/dumps"
: > "$SUMMARY"

for TAG in $TAGS; do
  for PS in $(compat_majors "$TAG"); do
    IMG=$(image_for "$PS")
    LABEL="$PS/$TAG"
    SAFE_PS="${PS//./_}"
    SAFE_TAG="${TAG//[.\/-]/_}"
    SUFFIX="${SAFE_PS}_${SAFE_TAG}"
    echo
    echo "============================================================"
    echo " [$LABEL] ps_image=$IMG"
    echo "============================================================"
    if DUMP_LABEL_OVERRIDE="$LABEL" DUMP_PROJECT_SUFFIX="$SUFFIX" \
       "$HERE/run-version.sh" "$TAG" "$IMG" > "$HERE/dumps/_log_${SUFFIX}.txt" 2>&1; then
      n=$(ls "$HERE/dumps/$LABEL" 2>/dev/null | wc -l)
      echo "[ok] $LABEL ($n files)"
      echo "ok   $LABEL $n" >> "$SUMMARY"
    else
      echo "[FAIL] $LABEL — see dumps/_log_${SUFFIX}.txt"
      echo "fail $LABEL" >> "$SUMMARY"
    fi
  done
done

echo
echo "=== Summary ==="
cat "$SUMMARY"
