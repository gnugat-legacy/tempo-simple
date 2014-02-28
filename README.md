# TempoSimple

A time tracking project: punch new time cards and generate reports!

Read more about this project in [its introduction](doc/01-introduction.md).

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/50ae922b-4070-4a64-a943-ce1278fb8c48/big.png)](https://insight.sensiolabs.com/projects/50ae922b-4070-4a64-a943-ce1278fb8c48)
[![Travis CI](https://travis-ci.org/gnugat/tempo-simple.png)](https://travis-ci.org/gnugat/tempo-simple)

## Features

    [x] Command Line interface (CLI)
    [ ] web service
    [ ] web interface

    [x] punch new time cards
    [x] generate a daily report
    [x] generate a weekly report
    [x] generate a billable report
    [ ] generate an activity report

    [x] default project
    [ ] project planned
    [x] default start hour

## Installation

To download and install this project, run the following command:

    curl -sS https://raw.github.com/gnugat/tempo-simple/master/bin/installer.sh | sh

Then create an alias: `alias ts='php app/console --env=prod'`

Learn more about the steps followed by the script by reading its
[documentation](doc/02-installation.md).

## Usage

You finished a session? Punch a new time card:

    ts punch '#4423 - Task with helpful title' '11:00'

You need to generate reports? Go for it:

    ts daily
    ts weekly
    ts billable

And if you're lost in the shell, simply ask for help:

    ts

Find out how to use it with the [usage guide](doc/03-usage.md).

## Further documentation

You can see the current and past versions using one of the following:

* the `git tag` command
* the [releases page on Github](https://github.com/gnugat/tempo-simple/releases)
* the file listing the [changes between versions](CHANGELOG.md)

You can find more documentation at the following links:

* [copyright and MIT license](LICENSE)
* [versioning and branching models](VERSIONING.md)
* [contribution instructions](CONTRIBUTING.md)
* [documentation directory](doc)
