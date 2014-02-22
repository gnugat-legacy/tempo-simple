#!/bin/sh

echo '[phpunit] Running functional tests'
vendor/bin/phpunit -c app
