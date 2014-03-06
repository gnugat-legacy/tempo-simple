# Architecture

* [Symfony2 architecture](#a-symfony2-project)
* [SpaghettiBundle](#pragmatism-and-technical-debt)
* [Application/DomainModel layers](#sources-architecture)

## A Symfony2 project

This is a [Symfony2 project](http://symfony.com/), which means that we have the
following directories:

* `app`: where the configuration lies
* `bin`: where script utils are
* `doc`: where the documentation is
* `src/TempoSimple`: where the project sources are
* `test`: where the tests are, [see its own documentation](04-tests.md)
* `vendor`: where the dependencies, installed by
  [Composer](https://getcomposer.org/), are
* `web`: where the front controllers and assets are

Symfony2 allows you to decouple completely your business logic from the
framework: you can first create the code in a OOP way and then integrate it
with bundles.

Bundles are composed of:

* Controllers which take HTTP Requests and return HTTP Responses
* Commands which take input and return an exit code
* Dependency Injection configuration
* View templates
* translation dictionaries
* routing configuration

When coupled with the [Doctrine ORM](http://www.doctrine-project.org/), bundles
also take the responsibility of the persistence layer:

* Entities which represent database tables
* Repositories which represent SQL queries against those tables

## Pragmatism and technical debt

In order to meet deadlines, shortcuts are taken. Don't panic, everything is
under control: see the [technical debt documentation](05.technical-debt.md).

In order to avoid waste of time on `where should I put this?` questions, a
holdall directory is present: `SpaghettiBundle`.

## Sources organization

The directory structure is based on Randy Stafford's
[Service Layer](http://martinfowler.com/eaaCatalog/serviceLayer.html), described
in Martin Fowler's book Patterns of Enterprise Application Architecture.

This means we should have the following tree:

* `Application`: the interface layer, where the controller and commands are
* `Service`: the boundary between the Application and the DomainModel layers
* `DomainModel`: the domain layer, where classes modelize the business logic
* `DataSource`: the persistence layer, where entites and repositories are

The `Application` queries the `DataSource` through `Services` which manipulate
`DomainModels`.

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
* [usage](03-usage.md)
* [tests](04-tests.md)
* [technical debt](05-technical-debt.md)
* [glossary](06-glossary.md)
