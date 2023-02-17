#!/bin/bash
set -e
set -o pipefail

# Input validation
if [ -z "$GITHUB_API_TOKEN" ];
  then echo "Error: Please define a GITHUB_API_TOKEN variable." >&2;
  exit 1;
fi;

if [ -z "$GITHUB_REPOSITORY" ];
  then echo "Error: Please define a GITHUB_REPOSITORY variable." >&2;
  exit 1;
fi;

if [ -z "$TARGET_VERSION" ];
  then echo "Error: Please define a TARGET_VERSION variable." >&2;
  exit 1;
fi;

if [ -z "$TARGET_ASSET" ];
  then echo "Error: Please define a TARGET_ASSET variable." >&2;
  exit 1;
fi;

# Define variables
GH_REPO_URL="https://api.github.com/repos/$GITHUB_REPOSITORY"
ASSET_PATH=${ASSET_PATH:-"/asset"}

# Validate token
curl --fail -s -L -H "Authorization: token $GITHUB_API_TOKEN" "$GH_REPO_URL" > /dev/null || { 
  echo "Error: Invalid repo, token or network issue!";
  exit 1;
}

# Get the asset id
URL="$GH_REPO_URL/releases/tags/$TARGET_VERSION";
RES=$(curl --fail -s -L -H "Accept: application/vnd.github+json" -H "Authorization: token $GITHUB_API_TOKEN" "$URL")
ASSET_ID=$(echo "$RES" | jq -r '.assets[] | select(.name == "'$TARGET_ASSET'").id') || { 
  echo "Error: failed to get asset id for $TARGET_ASSET (version $TARGET_VERSION) in $GITHUB_REPOSITORY";
  exit 2;
}

# Download the github asset
echo "Downloading asset $TARGET_ASSET with id:$ASSET_ID...";
OUTPUT="${ASSET_PATH}/${FINAL_ASSET:-$TARGET_ASSET}";
curl --fail -LJ -o $OUTPUT -H "Accept: application/octet-stream" -H "Authorization: token $GITHUB_API_TOKEN" "$GH_REPO_URL/releases/assets/$ASSET_ID" || { 
  echo "Error: cannot download the requested asset";
  exit 3;
}

echo "Asset is now available at: ${OUTPUT}";
