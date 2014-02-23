#!/bin/sh

echo '[phpunit] Running functional tests'
vendor/bin/phpunit -c app

echo '[phpspec] Running specification tests'
vendor/bin/phpspec --config=app/phpspec.yml.dist run
