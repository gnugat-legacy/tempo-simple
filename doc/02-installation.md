# Installation

Quickly install TempoSimple using this command:

    curl -sS https://raw.github.com/gnugat/tempo-simple/master/bin/installer.sh | sh

You want to know what's behind this script? Then read on.

## 1. Downloading

In order to install the project, the script download the project using git
(allowing you to run `git pull` to get the newest updates):

    git clone https://github.com/gnugat/tempo-simple.git
    cd tempo-simple

Then it will download [Composer](http://getcomposer.org/):

    echo '[curl] Getting Composer, the PHP dependency manager'
    curl -sS https://getcomposer.org/installer | php

Finally it will download the project's dependencies using Composer:

    echo '[composer] Downloading the dependencies'
    php composer.phar install --no-dev --optimize-autoloader

**Note**: at the end of the download, Composer will ask you some configuration
questions.

### For development purpose

To install the project for development purpose, you should install the
development dependencies using Composer:

    php composer.phar install

## 2. Database

Having the sources isn't enough. The script will take care of creating the
database for you:

    php app/console doctrine:database:create
    php app/console doctrine:schema:create

## Next readings

* [usage](03-usage.md)
* [tests](04-tests.md)
* [technical debt](05-technical-debt.md)
* [glossary](06-glossary.md)

## Previous readings

* [introduction](01-introduction.md)
