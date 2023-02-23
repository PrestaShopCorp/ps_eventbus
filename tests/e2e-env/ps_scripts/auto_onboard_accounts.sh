#!/bin/sh
set -e -o pipefail

# Install some tools
apk add -U jq curl mariadb-client

# Env Configuration
SSO_URL="https://auth.prestashop.com/api/v1/auth/sign-in/?lang=en"
ACCOUNTS_URL="https://accounts-api.distribution.prestashop.net"
PS_DOMAIN=$(curl -s 'http://ngrok:4040/api/tunnels' \
  | jq -r .tunnels[0].public_url \
  | sed 's/https\?:\/\///' \
)
FRONT_URL="https://${PS_DOMAIN}"
BO_URL="https://${PS_DOMAIN}/ps-admin/index.php" #@TODO get this from prestashop instead

echo
echo "1. Retrieve the Accounts Token"
echo "=============================="
AUTH=$(curl --fail -s -L "${SSO_URL}" \
  -H "accept: application/json" \
  -H "content-type: application/json" \
  --connect-timeout 3 \
  --retry 6 \
  --retry-delay 3 \
  --data-raw "{\"app\":\"accounts.distribution.prestashop.net\",\"email\":\"$PS_ACCOUNTS_USER\",\"password\":\"$PS_ACCOUNTS_PWD\"}") || {
    echo "Error: could not retrieve SSO token from user ${PS_ACCOUNTS_USER} on ${SSO_URL}";
    exit 2;
  }
TOKEN=$(echo "$AUTH" | jq -r '.token');
PS_ACCOUNTS_USER_ID=$(echo "$AUTH" | jq -r '.data.uid');
#REFRESH_TOKEN=$(echo "$AUTH" | jq -r '.refreshToken');

echo
echo "2. Retrieve the PS Accounts Public key"
echo "======================================"
SQL_QUERY="SELECT value FROM ps_configuration where name='PS_ACCOUNTS_RSA_PUBLIC_KEY'";
PS_ACCOUNTS_PUBLIC_KEY=$(mysql \
  --host "${MYSQL_HOST}" \
  --port="${MYSQL_PORT}" \
  --user "${MYSQL_USER}" \
  -p"${MYSQL_PASSWORD}" \
  --database "${MYSQL_DATABASE}" \
  --default-character-set=utf8 \
  -N -se "$SQL_QUERY");
echo -e $PS_ACCOUNTS_PUBLIC_KEY > public_key.json;

# JSON format (replaces line breaks etc)
str=$(jq -sR < public_key.json);

# Remove the quotes and the last \n
publickey=${str:1:-3};

# Replace \r\n by \\r\\n
PS_ACCOUNTS_PUBLIC_KEY=$publickey;

echo
echo "3. Associate the shop to Accounts"
echo "================================="
JSON_PAYLOAD='{
  "shops": [
    {
      "id":"1",
      "name":"PrestaShop",
      "domain":"'${PS_DOMAIN}'",
      "domainSsl":"'${PS_DOMAIN}'",
      "physicalUri":"/",
      "virtualUri":"",
      "frontUrl":"'${FRONT_URL}'",
      "employeeId":"1",
      "url":"'${BO_URL}'",
      "isLinkedV4":false,
      "multishop":false,
      "moduleName":"cloudsync_test_suite",
      "psVersion":"1.7.8.7",
      "allowAnonymousDataCollection":true,
      "publicKey":"'${PS_ACCOUNTS_PUBLIC_KEY}'"
    }
  ]
}';

ENDPOINT="${ACCOUNTS_URL}/v1/user/${PS_ACCOUNTS_USER_ID}/shops"
echo ${JSON_PAYLOAD} | curl --fail -s -L -XPOST ${ENDPOINT} \
  -H "accept: */*" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer ${TOKEN}" \
  --connect-timeout 5 \
  --retry 6 \
  --retry-delay 3 \
  -d @- || {
  echo "Error: failed to associate shop ${PS_DOMAIN} to user ${PS_ACCOUNTS_USER_ID} with the Acounts API";
  exit 3;
}

echo "Shop linked to PrestaShop Accounts 🎉"
