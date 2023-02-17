#!/bin/bash
set -e

# Ngrok configuration
apt-get -qq update
apt-get -yqq install jq
echo "=========================================="
PS_DOMAIN=$( \
  curl -s 'http://ngrok:4040/api/tunnels' \
  | jq -r .tunnels[0].public_url \
  | sed 's/https\?:\/\///' \
)

if [ -z "$PS_DOMAIN" ]; then
  echo "Error: cannot guess ngrok domain. Exiting" && exit 2;
else
  echo "🎊🎊🎊🎊 $PS_DOMAIN 🎊🎊🎊🎊 ngrok detected !"
fi

# Hard coding the variable within docker_run.sh
sed -i "2 i PS_DOMAIN=$PS_DOMAIN" /tmp/docker_run.sh