#!/bin/bash

# Define colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
CYAN='\033[0;36m'
NC='\033[0m' # No Color

# Parameters
REPO_URL="https://github.com/PrestaShop/PrestaShop.git"
TABLE_COLUMN="$1"
REPO_PATH="$2"
FILE="install-dev/data/db_structure.sql"

if [ -z "$TABLE_COLUMN" ]; then
  echo -e "${RED}❌ Usage : $0 <table.column> [repo_path]${NC}"
  echo "Example : $0 connections.ip_address ~/projects/PrestaShop"
  exit 1
fi

# Split table and column
TABLE=$(echo "$TABLE_COLUMN" | cut -d '.' -f 1)
COLUMN=$(echo "$TABLE_COLUMN" | cut -d '.' -f 2)

if [ -z "$TABLE" ] || [ -z "$COLUMN" ]; then
  echo -e "${RED}❌ Invalid format. Use table.column (e.g., connections.ip_address)${NC}"
  exit 1
fi

# Manage the repo (local or clone)
CLEANUP="false"

if [ -z "$REPO_PATH" ]; then
  TMP_DIR=$(mktemp -d)
  REPO_PATH="$TMP_DIR"
  echo -e "${BLUE}🚀 Cloning repository from $REPO_URL...${NC}"
  git clone --quiet "$REPO_URL" "$REPO_PATH"
  if [ $? -ne 0 ]; then
    echo -e "${RED}❌ Failed to clone repository.${NC}"
    exit 1
  fi
  CLEANUP="true"
else
  if [ ! -d "$REPO_PATH/.git" ]; then
    echo -e "${RED}❌ The provided path is not a valid Git repository: $REPO_PATH${NC}"
    exit 1
  fi
  echo -e "${BLUE}📂 Using local repository: $REPO_PATH${NC}"
fi

cd "$REPO_PATH"

echo -e "${CYAN}🔍 Searching for column '$COLUMN' in table '$TABLE'...${NC}"

LAST_TABLE_BLOCK=""
ERROR_LOGS=""

check_column_in_commit() {
    local commit=$1

    CONTENT=$(git show "${commit}:${FILE}" 2>/dev/null)
    if [ $? -ne 0 ]; then
        ERROR_LOGS+="${RED}❌ [$commit] File $FILE does not exist in this commit.${NC}\n"
        return 2
    fi

    TABLE_BLOCK=$(echo "$CONTENT" | awk -v table="PREFIX_${TABLE}" '
        BEGIN {capture=0}
        (toupper($0) ~ "CREATE[ ]*TABLE" && $0 ~ ("`" table "`")) {capture=1}
        capture==1 {print}
        capture==1 && $0 ~ /^[ ]*\)[ ]*ENGINE=/ {capture=0}
    ')

    if [ -z "$TABLE_BLOCK" ]; then
        ERROR_LOGS+="${RED}❌ [$commit] Table PREFIX_${TABLE} not found.${NC}\n"
        return 3
    fi

    LAST_TABLE_BLOCK="$TABLE_BLOCK"

    echo "$TABLE_BLOCK" | grep -q "\`${COLUMN}\`"
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}🎯 [$commit] Column '${COLUMN}' found in table '${TABLE}'.${NC}"
        return 0
    else
        return 1
    fi
}

COMMITS=$(git log --format="%H" --reverse -- "$FILE")

FOUND="false"

for COMMIT in $COMMITS
do
    check_column_in_commit "$COMMIT"
    RESULT=$?

    if [ $RESULT -eq 0 ]; then
        echo -e "${GREEN}✅ Column '${COLUMN}' exists in table '${TABLE}' since commit: $COMMIT${NC}"
        TAGS=$(git tag --contains $COMMIT)

        if [ -z "$TAGS" ]; then
            echo -e "${YELLOW}⚠️ No tag found containing this commit (it may be in the development branch)${NC}"
        else
            CLEAN_TAGS=$(echo "$TAGS" | grep -Ev '^(list|show)$' | sort -V)
            FIRST_TAG=$(echo "$CLEAN_TAGS" | head -n 1)
            LAST_TAG=$(echo "$CLEAN_TAGS" | tail -n 1)
            echo -e "${CYAN}🏷️  Present from tag: ${GREEN}$FIRST_TAG${CYAN} to ${GREEN}$LAST_TAG${NC}"
        fi

        echo -e "${BLUE}📜 Commit details :${NC}"
        git --no-pager log -1 $COMMIT

        echo -e "\n${CYAN}📄 Full table definition when the column was introduced:${NC}\n"
        echo "$LAST_TABLE_BLOCK"

        FOUND="true"
        break
    fi
done

if [ "$FOUND" == "false" ]; then
    echo -e "$ERROR_LOGS"
    echo -e "${RED}❌ The column '${COLUMN}' in table '${TABLE}' was not found in the history of $FILE${NC}"
fi

# Cleanup
if [ "$CLEANUP" == "true" ]; then
  cd - > /dev/null
  rm -rf "$TMP_DIR"
  echo -e "${BLUE}🧹 Temporary folder removed.${NC}"
else
  cd - > /dev/null
fi
