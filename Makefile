dockerCtnWeb=gestionfrais_web
dockerCtnPhp=gestionfrais_php

.DEFAULT_GOAL:=help

help: ## Show this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

start: ## Start all containers
	docker-compose up -d

stop: ## Stop all containers
	docker-compose down

restart: stop start ## Stop and start all containers

logs: ## Display docker logs in real-time
	docker-compose logs -f

bdd: ## Update structure bdd
	docker exec $(dockerCtnPhp) php bin/console doctrine:schema:update --force

fixtures: ## Load fixtures
	docker exec $(dockerCtnPhp) php bin/console doctrine:fixtures:load

sf-update: ## Update Symfony
	docker exec $(dockerCtnPhp) composer update "symfony/*"

vendors-update: ## Update all of vendors (composer)
	docker exec $(dockerCtnPhp) composer update

packages-update: ## Update all of packages (yarn)
	docker exec $(dockerCtnPhp) yarn upgrade

encore-dev-watch: ## Encore build dev watch
	docker exec $(dockerCtnPhp) yarn encore dev --watch

build-docker: ## Build docker images
	cd docker/phpfpm && docker build -t gestionfraisphp .
