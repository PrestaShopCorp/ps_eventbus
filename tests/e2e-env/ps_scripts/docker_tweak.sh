#!/bin/bash
set -e
cd "$(dirname "$0")"
export DEBIAN_FRONTEND=noninteractive

echo "============ REGISTER INIT SCRIPTS ============"
mkdir -p /tmp/init-scripts/
cp enable_debug.sh /tmp/init-scripts/

# Ensure all the files are executable
chmod +x /tmp/init-scripts/*.sh

# Run the former startup script
cd /var/www/html
/tmp/docker_run.sh
