# Variables
DUMP_SCRIPT=./scripts/dump-prestashop.sh
RESTORE_SCRIPT=./scripts/restore-prestashop.sh
DUMP_DIR=./databasesDumps


help: ## help: Affiche cette aide
	@echo "📦 Commandes disponibles :"
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' Makefile \
		| sort \
		| awk 'BEGIN {FS = ":.*?## "}; {printf "🛠  \033[36m%-15s\033[0m %s\n", $$1, $$2}'
.PHONY: help

dump: ## dump: Génère un dump SQL de la base PrestaShop (avec version dans le nom)
	bash $(DUMP_SCRIPT) $(DUMP_DIR)
.PHONY: dump

restore: ## restore: Restaure la base PrestaShop à partir du dump
	bash $(RESTORE_SCRIPT) $(DUMP_DIR)
.PHONY: restore
