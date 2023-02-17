#!/bin/bash
set -e
set -o pipefail

# install some tools
apk add -U jq curl mariadb-client

echo
echo "1. Retrieve the Accounts Token"
echo "=============================="
AUTH=$(curl -Ls "https://auth.prestashop.com/api/v1/auth/sign-in/?lang=en" \
  -H "accept: application/json" \
  -H "content-type: application/json" \
  --data-raw "{\"app\":\"accounts.distribution.prestashop.net\",\"email\":\"$PS_ACCOUNTS_USER\",\"password\":\"$PS_ACCOUNTS_PWD\"}")
TOKEN=$(echo "$AUTH" | jq -r '.token');
PS_ACCOUNTS_USER_ID=$(echo "$AUTH" | jq -r '.data.uid');
#REFRESH_TOKEN=$(echo "$AUTH" | jq -r '.refreshToken');

echo
echo "2. Retrieve the PS Accounts Public key"
echo "======================================"
#get account public key and json format
SQL="SELECT value FROM ps_configuration where name='PS_ACCOUNTS_RSA_PUBLIC_KEY'"
PS_ACCOUNTS_PUBLIC_KEY=$(mysql --host "${MYSQL_HOST}" --port="${MYSQL_PORT}" --user "${MYSQL_USER}" -p"${MYSQL_PASSWORD}" --database "${MYSQL_DATABASE}" --default-character-set=utf8  -N -se "$SQL")
touch key.json
echo -e $PS_ACCOUNTS_PUBLIC_KEY > key.json
#json format (replaces line breaks etc)
str=$(jq -sR < key.json)
#remove the quotes and the last \n
publickey=${str:1:-3}
#replace \r\n by \\r\\n
PS_ACCOUNTS_PUBLIC_KEY=$publickey

ACCOUNT_URL=https://accounts-api.distribution.prestashop.net
PS_DOMAIN=$( \
  curl -s 'http://ngrok:4040/api/tunnels' \
  | jq -r .tunnels[0].public_url \
  | sed 's/https\?:\/\///' \
)
FRONT_URL="https://${PS_DOMAIN}"
BO_URL="https://${PS_DOMAIN}/ps-admin/index.php"

echo "ACCOUNT_URL=\"${ACCOUNT_URL}\""
echo "PS_DOMAIN=\"${PS_DOMAIN}\""
echo "FRONT_URL=\"${FRONT_URL}/\""
echo "BO_URL=\"${BO_URL}\""
echo "PS_ACCOUNTS_PUBLIC_KEY=\"${PS_ACCOUNTS_PUBLIC_KEY}\""


echo
echo "3. Associate ps_account module to the shop"
echo "=========================================="
curl -s -X POST "https://accounts-api.distribution.prestashop.net/v1/user/$PS_ACCOUNTS_USER_ID/shops" \
  -H "accept: */*" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "{\"shops\":[{\"id\":\"1\",\"name\":\"PrestaShop\",\"domain\":\"$PS_DOMAIN\",\"domainSsl\":\"$PS_DOMAIN\",\"physicalUri\":\"/\",\"virtualUri\":\"\",\"frontUrl\":\"$FRONT_URL\",\"employeeId\":\"1\",\"url\":\"$BO_URL\",\"isLinkedV4\":false,\"multishop\":false,\"moduleName\":\"ps_accounts\",\"psVersion\":\"1.7.8.7\",\"allowAnonymousDataCollection\":true,\"publicKey\":\"$PS_ACCOUNTS_PUBLIC_KEY\"}]}"
# TODO: {"statusCode":400,"message":["PrestaShop Your shop is already linked an should provide an exit code 0
# but a curl with `--fail` should help to fail correctly with error code >0 if a 500 error is raised

echo "Shop linked to PrestaShop Accounts 🎉"
