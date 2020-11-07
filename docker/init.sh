#bin/bash
#!/usr/bin/env bash
if [ ! -d "vendor" ]; then
  composer install
fi
if [ ! -d "node_modules" ]; then
  yarn install
fi

yarn encore dev
php bin/console doctrine:migration:migrate -n
php bin/console doctrine:fixtures:load -n
php-fpm -F