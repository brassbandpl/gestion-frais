.DEFAULT_GOAL:=help

help: ## Show this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

start: ## Start all containers
	docker-compose pull
	docker-compose up -d

stop: ## Stop all containers
	docker-compose down

restart: stop start ## Stop and start all containers

logs: ## Display docker logs in real-time
	docker-compose logs -f

bdd: ## Update structure bdd
	docker-compose exec php bin/console doctrine:schema:update --force

migration-migrate: ## Update bdd (migrations)
	docker-compose exec php bin/console doctrine:migration:migrate

fixtures: ## Load fixtures
	docker-compose exec php bin/console doctrine:fixtures:load

sf-update: ## Update Symfony
	docker-compose exec php composer update "symfony/*"

vendors-update: ## Update all of vendors (composer)
	docker-compose exec php composer update

packages-update: ## Update all of packages (yarn)
	docker-compose exec php yarn upgrade

encore-dev-watch: ## Encore build dev watch
	docker-compose exec php yarn encore dev --watch

build-docker: ## Build docker images
	cd docker/phpfpm && docker build -t gestionfraisphp .

ut: ## Run unit tests
	docker-compose exec php bin/phpunit

bash-php: ## Open bash on php container
	docker-compose exec php bash