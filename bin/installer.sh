#!/bin/sh

echo '[git] Downloading the project'
git clone https://github.com/gnugat/tempo-simple.git
cd tempo-simple

echo '[curl] Getting Composer, the PHP dependency manager'
curl -sS https://getcomposer.org/installer | php

echo '[composer] Downloading the dependencies'
php composer.phar install --no-dev --optimize-autoloader

echo '[console] Creating database'
php app/console --env=prod doctrine:database:create
php app/console --env=prod doctrine:schema:create
