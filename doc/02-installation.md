# Installation

The installation steps described in this file are followed by the
`bin/installer.sh` script.

## 1. Downloading

In order to install the project, you need to:

Download the project using git (this will allow you to run `git pull` to get the
newest updates):

    git clone https://github.com/gnugat/tempo-simple.git
    cd tempo-simple

Download [Composer](http://getcomposer.org/):

    echo '[curl] Getting Composer, the PHP dependency manager'
    curl -sS https://getcomposer.org/installer | php

Download the project's dependencies using Composer:

    echo '[composer] Downloading the dependencies'
    php composer.phar install --no-dev --optimize-autoloader

### For development purpose

To install the project for development purpose, follow the exact same steps
as above except for the composer one:

    php composer.phar install

## 2. Database

Create the database:

    php app/console --env=prod doctrine:database:create
    php app/console --env=prod doctrine:schema:create

### For test purpose

To install the project for test purpose:

    php app/console --env=test doctrine:database:create
    php app/console --env=test doctrine:schema:create

## Next readings

* [usage](03-usage.md)
* [tests](04-tests.md)
* [technical debt](05-technical-debt.md)
* [glossary](06-glossary.md)

## Previous readings

* [introduction](01-introduction.md)
