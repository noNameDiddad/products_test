#!/usr/bin/make -f
# SHELL = /bin/sh

ENVFILE=.env
MAKEFILE_PATH=.
DC_LOCAL_FILE=./docker-compose.yml
DC_TEST_FILE=./docker-compose-test.yml

ifneq ("$(wildcard ./app/.env)","")
	# ENVFILE=.env
	APP_DIR=$(shell echo $$(cd . && pwd))
else
	# ENVFILE=../.env
	APP_DIR=$(shell echo $$(cd .. && pwd))
	MAKEFILE_PATH=$(shell basename $$(cd . && pwd))
endif

SHELL = /bin/sh
.DEFAULT_GOAL = help
.PHONY: help down up clear update build first_install tests_run

DC=
COPY=cp
RM=rm -rf

help:
	@echo Usage:
	@echo "   make <command> [<command>, [<command>, ...]]"
	@echo -----
	@echo Available commands:
	@echo "   up             Up projects"
	@echo "   down           Down projects"
	@echo "   update         Update docker images"
	@echo "   build          Build docker images"
	@echo "   first_install  First installation of the project"
	@echo "   clear   Clear docker system folder"


down:
	cd $(APP_DIR) && docker-compose down -v --remove-orphans

up:
	docker rm -f $$(docker ps -a | grep orders | awk '{print $$1}') || echo
	cd $(APP_DIR) && docker-compose up -d --remove-orphans --force-recreate
	cd $(APP_DIR) && $(DC) docker-compose exec -T php /bin/bash -c "COMPOSER_MEMORY_LIMIT=-1 composer install --prefer-dist --no-ansi --no-scripts --no-interaction --no-progress"
	cd $(APP_DIR) && $(DC) docker-compose exec -u root -T php bash -c "mkdir -p storage/logs && chown -R www-data:www-data storage/logs"
	cd $(APP_DIR) && $(DC) docker-compose exec -T php /bin/bash -c "php artisan key:generate"
	@echo ---------------------------------------------
	@echo =============================================
	@echo == Done
	@echo =============================================

clear:
	docker-compose down -v --remove-orphans
	docker container prune -f
	docker image prune -f
	docker volume prune -f
	docker network prune -f
	docker network create orders-network || echo Created
	@echo "======================="

update:
	cd $(APP_DIR) && docker-compose pull

build:
	cd $(APP_DIR) && docker-compose build

first_install:
	cp ./app/.env.example ./app/.env
	docker network create guare-network || echo Created
	$(MAKE) build -
	$(MAKE) up

exec-bash:
	docker-compose exec -T php bash -c "$(cmd)"

migrate:
	@make exec-bash cmd="php artisan migrate --force"

fresh-seed:
	@make exec-bash cmd="php artisan migrate:fresh --seed"

sh:
	cd $(APP_DIR) && docker-compose exec -it php /bin/bash
