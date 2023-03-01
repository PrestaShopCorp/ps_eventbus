#!/bin/bash
set -e
cd "$(dirname "$0")"
export DEBIAN_FRONTEND=noninteractive

echo "============ START E2E TWEAK ============"

echo "============ REGISTER POST INSTALL SCRIPTS ============"
mkdir -p /tmp/post-install-scripts/
cp ./install_modules.sh /tmp/post-install-scripts/1-install_modules.sh

# Ensure all the files are executable
chmod +x /tmp/post-install-scripts/*.sh

echo "============ REGISTER INIT SCRIPTS ============"
mkdir -p /tmp/init-scripts/
cp enable_debug.sh /tmp/init-scripts/

# Ensure all the files are executable
chmod +x /tmp/init-scripts/*.sh

echo "============ DOCKER E2E PERFOMED ============"

# Run the former startup script
cd /var/www/html
/tmp/docker_run.sh
