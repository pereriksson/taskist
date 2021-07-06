# todoist

A todo application.

[![Build Status](https://travis-ci.com/pereriksson/taskist.svg?branch=master)](https://travis-ci.com/pereriksson/taskist)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/pereriksson/taskist/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/pereriksson/taskist/?branch=master)

[![Build Status](https://scrutinizer-ci.com/g/pereriksson/taskist/badges/build.png?b=master)](https://scrutinizer-ci.com/g/pereriksson/taskist/build-status/master)



## Introduction

This is a simple but effective todo application made to demonstrate the Symfony framework with Doctrine. It provides basic functionality to add todo items in a hierarchy fashion, annotated with a responsible, deadline, responsibles, projects, tags and more.

It was built as part of the Object Oriented Web Technologies course at Blekinge Institute of Technology.

## Installing

To install this application, clone this repository, then run the following:

```shell
composer install
php bin/console make:migration
```

## Adding projects, tags and responsibles

Some entities can only be manipulated from the database command line. Projects, tags and responsibles are manipulated through the CLI, e g:

```mysql
insert into person values(null, "Amanda Mount");
insert into person values(null, "Andrew Lin");

insert into tag values(null, "important");
insert into tag values(null, "new");

insert into project values(null, "Renovating the house");
insert into project values(null, "Finding a new car");
```

## Testing

Tests can be run by running:

```shell
make test
```

## Contributing

This repository may be forked by anyone. Please speak to the author for original contributions.
