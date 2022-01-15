SHELL = /bin/sh

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.SILENT .PHONY: help
help: ## Display available targets
	awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-20s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.SILENT .PHONY: build
build:
	docker-compose build --no-cache

.SILENT .PHONY: run
run: ## Run Mezzio app
	docker-compose up -d
	docker-compose exec php bash -c "\
		composer install --prefer-dist \
		&& etc/scripts/wait_for_mysql.sh mysql 3306 root root \
		&& vendor/bin/laminas pheature:dbal:init-toggle \
		&& bin/doctrine-migrations migrations:migrate --no-interaction \
	"

.SILENT .PHONY: remove
remove: ## Remove Mezzio app
	docker-compose down -v --remove-orphans

.SILENT .PHONY: php
php: ## Enter to the php container
	docker-compose exec php bash
