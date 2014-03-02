# Glossary

Here's the meaning of the vocabulary used in TempoSimple:

* [billable report](#billable-report)
* [daily report](#daily-report)
* [day](#day)
* [hour](#hour)
* [month](#month)
* [project](#project)
* [punching](#punching)
* [task](#task)
* [time card](#time-card)
* [timesheet](#timesheet)
* [time spent](#time-spent)
* [time tracking](#time-tracking)
* [weekly report](#weekly-report)
* [working days](#working-days)
* [working hours](#working-hours)

## Billable report

A report of the number of working days spent for each task in the last month.
Allows project managers to create bills for the customers.

## Daily report

A report of the tasks which have been worked on during the day. Should be sent
by email at the end of every days.

## Day

A date which contains the year, month and day numbers.

For example, 2013-04-01 would be the 1st of April, 2004.

## Hour

A time which contains the hour and minute numbers.

For example, 13:45 would be a quarter to two.

## Month

A date which contains the year and month numbers.

For example, 2012-12 would be December, 2012.

## Project

A product, an activity or an organization which owns a collection of tasks.

See [wikipedia's definition](http://en.wikipedia.org/wiki/Project#Project_management)

## Punching

The action of entering a new record.

See [wikipedia's article](http://en.wikipedia.org/wiki/Time_clock)

## Task

A piece of work to be done, for a given project.

See [wikipedia's definition](http://en.wikipedia.org/wiki/Task_(project_management)).

## Time card

A record of the start and end times for a task.

An employee might enter many start and end times for a same task, for example
they could start working on a first task, then switch to a second task and
finally come back to the first one.

An entry in the database is a
[time card](http://en.wikipedia.org/wiki/Timesheet#Time_cards).

## Timesheet

A collection of time cards.

The database where the time cards are stored is a
[timesheet](http://en.wikipedia.org/wiki/Timesheet).

## Time spent

The difference of working hours or working days between the begining of a time
card (or task) and its end.

## Time tracking

The practice of recording the time spent on tasks.

The TempoSimple project is a
[time tracking software](http://en.wikipedia.org/wiki/Time_tracking_software).

## Weekly report

A report of the tasks which have been worked on during the last week. Should be
sent by email every monday mornings.

## Working days

A unit of time spent: 8 hours make 1 working day.

A working day is composed of quarters: increments are done by stages of 2 hours
(0.25 working days).

## Working hours

A unit of time spent: 60 minutes make 1 working hour.

A working hour is composed of quarters: increments are done by stages of 15
minutes (0.25 working hours).

## Next readings

* [architecture](07-architecture.md)

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
* [usage](03-usage.md)
* [tests](04-tests.md)
* [technical debt](05-technical-debt.md)
