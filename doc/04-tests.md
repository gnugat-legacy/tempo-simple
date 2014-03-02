# Tests

The steps described in this document are followed by the `bin/tester.sh` script.

## Functional

Functional tests can be run using the following command:

    vendor/bin/phpunit -c app

Functional tests will simply run a command and check its exit status.

## Specification

Specification tests can be run using the following command:

    vendor/bin/phpspec --config=app run

Specification tests describes how a class should behave. It's similar to unit
tests, but with self explicit names for test methods.

To generate the specification, use the following command:

    vendor/bin/phpspec --config=app desc 'Acme\DemoBundle\AcmeDemoBundle'

The `bin/descripter.sh` script helps you with that.

## Next readings

* [technical debt](05-technical-debt.md)
* [glossary](06-glossary.md)
* [architecture](07-architecture.md)

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
* [usage](03-usage.md)
