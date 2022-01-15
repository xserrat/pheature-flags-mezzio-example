SHELL = /bin/sh

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: help
help: ## Display available targets
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {sub("\\\\n",sprintf("\n%22c"," "), $$2);printf " \033[36m%-20s\033[0m  %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: run
run: ## Run Mezzio app
	docker-compose up -d
	docker-compose exec php bash -c "\
		etc/scripts/wait_for_mysql.sh mysql 3306 root root \
		&& composer install \
		&& vendor/bin/laminas pheature:dbal:init-toggle \
	"

.PHONY: remove
remove: ## Remove Mezzio app
	docker-compose down -v --remove-orphans
