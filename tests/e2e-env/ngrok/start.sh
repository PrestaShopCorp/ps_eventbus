#!/bin/bash
set -e
set -o pipefail

if [ -z "$NGROK_TOKEN" ];
  then echo "Error: Please define a NGROK_TOKEN variable." >&2;
  exit 1;
fi;

if [ -z "$NGROK_CONFIG" ];
  then echo "Error: Please define a NGROK_CONFIG variable." >&2;
  exit 1;
fi;

echo "Starting ngrok... (if nothing happens here, it may work! Check your ngrok.com panel for a status)"
ngrok start --authtoken $NGROK_TOKEN --config $NGROK_CONFIG --all
