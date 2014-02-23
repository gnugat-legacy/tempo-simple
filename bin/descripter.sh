#!/bin/sh

echo '[phpspec] Describing a class'
vendor/bin/phpspec --config=app/phpspec.yml.dist desc $1
