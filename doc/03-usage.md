# Usage

TempoSimple is a command line utility. You can run the command to get help:

    php app/console --env=prod <command> -h

I advise you to create an alias (ts like TempoSimple):

    alias ts='php app/console --env=prod'

**Note**: For development purpose, use `php app/console` instead.

## Punching time cards

To enter a new record of your time spent on a project's task, run the following
command:

    ts punch -p='Project' '#4423 Task' '09:00' '09:30'

You can optionnaly add a description or a date:

    ts punch -p='Project' '#4423 Task' '09:00' '09:30' -D='description' -d='2014-02-14'

## Generate a daily report

Is this the end of the day? Then generate a daily report:

    ts daily

Did you forgot to send yesterday's daily report? Don't panic! You can specify
the date of the daily report you want to generate:

    ts daily -d='2014-02-13'

## Generate a weekly report

This is monday morning, and you can't attend to the weekly stand up? Generate
a weekly report:

    ts weekly

## Generate a billable activity report

Your project manager needs you to give how much days each tasks took this month?
Generate a billable report:

    ts billable 'Project'

You need to generate one for last month? Use the `month` option:

    ts billable 'Porject' -m='2014-01'

## Next readings

* [tests](04-tests.md)
* [technical debt](05-technical-debt.md)
* [glossary](06-glossary.md)

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
