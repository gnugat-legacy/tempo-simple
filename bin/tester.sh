#!/bin/sh

echo '[console] Creating database'
php app/console --env=test doctrine:database:create
php app/console --env=test doctrine:schema:create

echo '[phpunit] Running functional tests'
vendor/bin/phpunit -c app

echo '[phpspec] Running specification tests'
vendor/bin/phpspec --config=app/phpspec.yml.dist run

echo '[console] Dropping database'
php app/console --env=test doctrine:database:drop --force
