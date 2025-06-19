#!/bin/bash

# === Préfixes des containers ===
PRESTASHOP_PREFIX="ps_eventbus-prestashop"
MARIADB_PREFIX="ps_eventbus-mysql"

# === Infos DB ===
DB_NAME="prestashop"
DB_USER="root"
DB_PASS="prestashop"
# Si le dossier DUMP_DIR est passé en argument, on l'utilise
DUMP_DIR=${1:-"../databasesDumps"}  # Si rien n'est passé, on utilise la valeur par défaut

# 🔍 Trouver le container PrestaShop
PRESTASHOP_CONTAINER=$(docker ps --format '{{.Names}}' | grep "^${PRESTASHOP_PREFIX}" | head -n 1)
if [ -z "$PRESTASHOP_CONTAINER" ]; then
  echo "❌ Aucun container PrestaShop trouvé avec le préfixe : $PRESTASHOP_PREFIX"
  exit 1
fi
echo "🔍 Container PrestaShop détecté : $PRESTASHOP_CONTAINER"

# 🔍 Trouver le container MariaDB
MARIADB_CONTAINER=$(docker ps --format '{{.Names}}' | grep "^${MARIADB_PREFIX}" | head -n 1)
if [ -z "$MARIADB_CONTAINER" ]; then
  echo "❌ Aucun container MariaDB trouvé avec le préfixe : $MARIADB_PREFIX"
  exit 1
fi
echo "🔍 Container MariaDB détecté : $MARIADB_CONTAINER"

# 🔢 Récupérer la version de PrestaShop depuis l'image Docker
PRESTASHOP_IMAGE=$(docker inspect --format '{{.Config.Image}}' "$PRESTASHOP_CONTAINER")
# Extraire le tag (ex: 8.1.7-nginx ou latest)
PRESTASHOP_TAG=$(echo "$PRESTASHOP_IMAGE" | awk -F ':' '{print $2}')
# Extraire la version ou tag principal (avant le premier "-")
PRESTASHOP_VERSION=$(echo "$PRESTASHOP_TAG" | cut -d'-' -f1)

if [ -z "$PRESTASHOP_VERSION" ]; then
  echo "❌ Impossible de récupérer la version de PrestaShop"
  exit 1
fi

echo "🔧 Vérification de la présence de mysqldump dans le container..."

if ! docker exec "$MARIADB_CONTAINER" which mysqldump > /dev/null 2>&1; then
  echo "📦 mysqldump non trouvé. Installation en cours..."

  docker exec "$MARIADB_CONTAINER" sh -c 'apt-get update && apt-get install -y mysql-client'

  if [ $? -ne 0 ]; then
    echo "❌ Échec de l'installation de mariadb-client"
    exit 1
  fi

  echo "✅ mysqldump installé avec succès"
else
  echo "✅ mysqldump déjà présent"
fi

# 📄 Chemin du fichier de dump
DUMP_FILE="$DUMP_DIR/${PRESTASHOP_VERSION}_dump.sql"

# 🔍 Vérification que le fichier existe
if [ ! -f "$DUMP_FILE" ]; then
  echo "❌ Fichier de dump introuvable : $DUMP_FILE"
  exit 1
fi

echo "♻️ Restauration de la base '$DB_NAME' depuis '$DUMP_FILE'..."

# 💾 Restauration
docker exec -i "$MARIADB_CONTAINER" \
  mysql -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" < "$DUMP_FILE"

if [ $? -eq 0 ]; then
  echo "✅ Base de données '$DB_NAME' restaurée depuis $DUMP_FILE"
else
  echo "❌ Échec de la restauration"
  exit 1
fi
