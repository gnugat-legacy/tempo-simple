#!/bin/sh

echo '[git] Fetching changes'
git pull --rebase

echo '[curl] Getting Composer, the PHP dependency manager'
curl -sS https://getcomposer.org/installer | php

echo '[composer] Downloading the dependencies'
php composer.phar update --no-dev --optimize-autoloader

echo '[rm] Removing cache'
rm -rf ./app/cache/*
