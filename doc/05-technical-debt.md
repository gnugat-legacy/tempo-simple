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

* move the spaghetti bundle into `src/SpaghettiBundle`
* create a cli bundle in `src/Application/CliBundle`
* move the specifications into `test/specification`

## Model

* rename `src/DomainModel/TimeTracking` into `src/DomainModel/ProjectManagement`
* rename `Task` into `UserStory`
* rename `TimeCard` into `WorkSession`

## Services

* create `Context` as a facade to get default options

## Next readings

* [glossary](06-glossary.md)
* [architecture](07-architecture.md)

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
* [usage](03-usage.md)
* [tests](04-tests.md)
