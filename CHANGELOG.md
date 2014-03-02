# Changes between versions

## 0.2.2: Fix install

* removed `app/bootstrap.php.cache` file
* added check for database exceptions

## 0.2.1: Fix dependencies

* removed AsseticBundle
* removed SensioDistributionBundle
* removed SensioFrameworkExtraBundle
* changed console's environment from `dev` to `prod`

## 0.2.0: helpful context

* print a helpful cheat sheet with the default command
* default project in configuration
* default morning's start hour
* default afternoon' start hour
* start hour guessed from the last end hour
* documentation improvements
* support of PHP version 5.3.3

### Backward Compatibility Breaks

The `punch`'s `start-hour` argument became a simple option (with helpful default
values).

## 0.1.1: Refactoring session 1

* creation of the TimeTracking Domain
* creation of the TimeCard model
* creation of the Timesheet model
* creation of the Task model
* creation of the Project model

## 0.1.0: Command Line Interface (CLI)

* punch new time cards
* generate a daily report
* generate a weekly report
* generate a billable report
