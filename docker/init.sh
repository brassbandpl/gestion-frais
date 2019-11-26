#bin/bash
#!/usr/bin/env bash
if [ ! -d "vendor" ]; then
  composer install
fi
if [ ! -d "node_modules" ]; then
  yarn install
fi

yarn encore dev
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php-fpm -F