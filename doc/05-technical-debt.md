# Technical debt

> Ship it, ship it and ship it!
>
> But keep an eye on your dirty laundry.

TempoSimple is a rather small project, which means it should be quiclky
shippable. In order to do so, every shortcut is taken! But it doesn't mean that
the project quality must be dropped. So here's a report on the technical debt.

When it becomes big enough, clean it. And when it's clean enough, ship it, ship
it  and ship it again!

## Directories

* the spaghetti bundle should be split up:
  + rename `src/Bundle` into `src/ApplicationLayer` directory:
    - create a cli bundle
  + rename `src/Domain` into `src/DomainModel`
  + create a `src/DataSource` directory:
    - create a time tracking bundle

## Commands

* the logic is all in the commands:
  + create some services
  + make input converter, so web controllers can use the same process

## Model

* the model is higly coupled to Doctrine2: create some model class
* decouple the model from Doctrine2:
  + create domain repository
  + create gateway interfaces
  + create factories
* the schema isn't flexible:
  + create a project table
  + create a task table

## Next readings

* [glossary](06-glossary.md)

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
* [usage](03-usage.md)
* [tests](04-tests.md)
