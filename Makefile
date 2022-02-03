.SILENT:
.PHONY: assets generatemodel

## Colors
COLOR_RESET	= \033[0m
COLOR_INFO	 = \033[32m
COLOR_COMMENT  = \033[33m

## Composer file
COMPOSE_FILE = ./docker/docker-compose.yml

define add_host
	if ! grep -q $1 /etc/hosts; then \
		echo $2 | sudo tee -a /etc/hosts > /dev/null; \
		echo "127.0.0.1 $1" | sudo tee -a /etc/hosts > /dev/null; \
	fi
endef

## Help
help:
		printf "${COLOR_COMMENT}Usage:${COLOR_RESET}\n"
		printf " make [target]\n\n"
		printf "${COLOR_COMMENT}Commandes disponibles:${COLOR_RESET}\n"
		awk '/^[a-zA-Z\-\_0-9\.@]+:/ { \
			helpMessage = match(lastLine, /^## (.*)/); \
			if (helpMessage) { \
				helpCommand = substr($$1, 0, index($$1, ":")); \
				helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
				printf " ${COLOR_INFO}%-16s${COLOR_RESET} %s\n", helpCommand, helpMessage; \
			} \
		} \
		{ lastLine = $$0 }' $(MAKEFILE_LIST)

add-hosts:
	$(call add_host,"api.enduro.wip","# Enduro API dev")

## Install docker
install: generatekeys
	docker-compose -f $(COMPOSE_FILE) build
	docker-compose -f $(COMPOSE_FILE) run --rm php composer install

## Start docker
start:
	docker-compose -f $(COMPOSE_FILE) up -d

## Stop docker
stop:
	printf "${COLOR_COMMENT}Extinction de la docker:\n${COLOR_RESET}\n"
	docker-compose -f $(COMPOSE_FILE) down;
	printf "${COLOR_COMMENT}Docker Eteinte\n${COLOR_RESET}"

## Création de fichier de migration
createMigration:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/phinx create $(migration)

## Création de fichier de seed
createSeed:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/phinx seed:create $(seed)

## Execution des migrations
migrate:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/phinx migrate

## Execution des seeds
seeds:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/phinx seed:run

seed:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/phinx seed:run -s $(seed)

## Execution des tests
test:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/phpunit --testdox

## Execution des tests Behat
test-behat:
	docker-compose -f $(COMPOSE_FILE) run --rm php vendor/bin/behat

## Execution PHP CS fixer
php-cs:
	vendor/bin/php-cs-fixer fix src/

## Generate keys
generatekeys:
	openssl genrsa -out private.key 2048
	chmod 664 private.key
	openssl rsa -in private.key -pubout -out public.key

transaction-execute:
	docker-compose -f $(COMPOSE_FILE) run --rm php bin/console transaction:execute

recurrence-execute:
	docker-compose -f $(COMPOSE_FILE) run --rm php bin/console subscription-recurrence:execute
