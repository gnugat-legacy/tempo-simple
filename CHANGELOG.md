# Changes between versions

## 0.6.0: Printable activity

* created web view for activity report
* removed MySQL settings (except user and password)
* removed language setting
* fixed insight violations

## 0.5.0: Table billable

* changed billable view into a table
* created TaskCollections
* created updater script
* removed mocking from functional tests
* created queries

## 0.4.0: Activity report

* created the activity report command

## 0.3.2: Fixed end hour

* updated the documentation
* changed end hour argument into an option

### Backward Compatibility Breaks

The `punch`'s `end-hour` argument became a simple option (with helpful default
values).

## 0.3.1: Refactoring session 2

* added architecture documentation
* created DomainModel, Service and DataSource folders
* moved logic from commands to TimeTracking timesheet services
* moved date management to time factory services
* moved persistence layer into DataSource
* allowed any minutes to be supported in time spent computation

## 0.3.0: Guess end hour

* made end-hour argument optional
* guess end-hour using current time in quarter hour

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
