# Usage

**Note**: For now, there's only a Command Line Interface. Soon a web interface
should be available, be patient :) .

A cheat sheet is available to help you on:

* the available commands
* their arguments
* time formats
* current default settings

To print it, simply run the console without any arguments:

    php app/console

I advise you to create an alias (`ts` like TempoSimple):

    alias ts='php app/console --env=prod'

To get more help on each commands, run `ts <command> -h`

## Punching time cards

Here are some situation examples to help you understand the `punch` command.

## One task during the whole day

Let's say you had the following day:

1. you start at 9 o'clock and stop at noon
2. then you have lunch until 1 o'clock
3. finally you continue to work until 6 o'clock

To record the time spent, you'll run:

    ts punch '#4423 - hard task' '12:00'
    ts punch '#4423 - hard task' '18:00'

That's it! TempoSimple will have guessed the followings:

* the day's date (today)
* the project, based on the one set in the configuration
* the morning's start hour (9 o'clock)
* the afternoon's start hour (if you finish at noon, the start hour is 1 o'clock)

### Many sessions in one task

Generally you have sub-tasks in your tasks. You can micro manage your time spent
on these by punching time cards and adding a description:

    ts punch '#1337 - task with sub-tasks' '10:00' -D 'sub-task 1' -S '09:30'
    ts punch '#1337 - task with sub-tasks' '12:00' -D 'sub-task 2'
    ts punch '#1337 - task with sub-tasks' '13:30' -D 'sub-task 2'
    ts punch '#1337 - task with sub-tasks' '18:00' -D 'sub-task 3'

As you can see, we started our day at half past 9 instead of 9 o'clock, so we
used the `-S` (or `--start-hour`) option.

You can put anything in the `-D` (or `--description`) option: the sub task
title, or precisions on what you exactly did.

## Reports

Usually, you would print a daily report at the end of the day:

    ts daily

But if for some reason you forgot to, you can still set a day option:

    ts daily -d '2014-02-28'

Weekly reports are generally sent on monday mornings:

    ts weekly

And at the end of the month, you can report the number of working days (8 hours
= 1 working day) for each task of the project to your manager:

    ts billable

Use the `-p` (or `--project`) option to set the project you want.

## Configuration

In order to change the default project or other configuration parameters, you
need to edit the `app/config/parameters.yml` file.

## Next readings

* [tests](04-tests.md)
* [technical debt](05-technical-debt.md)
* [glossary](06-glossary.md)

## Previous readings

* [introduction](01-introduction.md)
* [installation](02-installation.md)
