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

# Vérification que le répertoire existe
if [ ! -d "$DUMP_DIR" ]; then
  echo "❌ Le répertoire $DUMP_DIR n'existe pas !!"
  exit 1
fi

# 🔍 Trouver le container PrestaShop
PRESTASHOP_CONTAINER=$(docker ps --format '{{.Names}}' | grep "^${PRESTASHOP_PREFIX}" | head -n 1)
if [ -z "$PRESTASHOP_CONTAINER" ]; then
  echo "❌ Aucun container PrestaShop trouvé avec le préfixe : $PRESTASHOP_PREFIX"
  exit 1
fi
echo "🔍 Container PrestaShop détecté : $PRESTASHOP_CONTAINER"

# Récupérer le nom de l'image Docker du conteneur PrestaShop
PRESTASHOP_IMAGE=$(docker inspect --format '{{.Config.Image}}' "$PRESTASHOP_CONTAINER")

# Extraire le tag (ex: 8.1.7-nginx ou latest)
PRESTASHOP_TAG=$(echo "$PRESTASHOP_IMAGE" | awk -F ':' '{print $2}')

# Extraire la version ou tag principal (avant le premier "-")
PRESTASHOP_VERSION=$(echo "$PRESTASHOP_TAG" | cut -d'-' -f1)

# Nom du fichier de dump basé sur la version de PrestaShop
DUMP_FILE="$DUMP_DIR/$PRESTASHOP_VERSION"_dump.sql

# 🔍 Trouver le container MariaDB
MARIADB_CONTAINER=$(docker ps --format '{{.Names}}' | grep "^${MARIADB_PREFIX}" | head -n 1)
if [ -z "$MARIADB_CONTAINER" ]; then
  echo "❌ Aucun container MariaDB trouvé avec le préfixe : $MARIADB_PREFIX"
  exit 1
fi
echo "🔍 Container MariaDB détecté : $MARIADB_CONTAINER"

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


# 🕵️ Attente que PrestaShop soit healthy
echo "⏳ Attente de l'état healthy du container '$PRESTASHOP_CONTAINER'..."
until [ "$(docker inspect -f '{{.State.Health.Status}}' "$PRESTASHOP_CONTAINER")" == "healthy" ]; do
    sleep 5
    echo "⌛ Toujours en attente..."
done

echo "✅ PrestaShop est healthy. Lancement du dump..."

# 💾 Exécution du dump
docker exec "$MARIADB_CONTAINER" \
  mysqldump -u"$DB_USER" -p"$DB_PASS" --skip-column-statistics "$DB_NAME" > "$DUMP_FILE"

if [ $? -eq 0 ]; then
  echo "📦 Dump réussi → $DUMP_FILE"
else
  echo "❌ Erreur pendant le dump"
  exit 1
fi
