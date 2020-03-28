.DEFAULT_GOAL:=help

help: ## Show this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

start: ## Start db container and symfony server
	docker-compose up -d
	symfony proxy:start
	symfony proxy:domain:attach bbpl-ik
	symfony server:start

stop: ## Stop symfony server and db container
	symfony server:stop
	docker-compose down

restart: stop start ## Stop and start all containers

docker-logs: ## Display docker logs in real-time
	docker-compose logs -f

bdd: ## Update structure bdd
	symfony php bin/console doctrine:schema:update --force

fixtures: ## Load fixtures
	symfony php bin/console doctrine:fixtures:load

sf-update: ## Update Symfony
	symfony composer update "symfony/*"

vendors-update: ## Update all of vendors (composer)
	symfony composer update

packages-update: ## Update all of packages (yarn)
	symfony yarn upgrade

encore-dev-watch: ## Encore build dev watch
	symfony yarn encore dev --watch

build-docker: ## Build docker images
	cd docker/phpfpm && docker build -t gestionfraisphp .

ut: ## Run unit tests
	symfony php bin/phpunit
