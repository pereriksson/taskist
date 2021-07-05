# todoist

A todo application.

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

## Contributing

This repository may be forked by anyone. Please speak to the author for original contributions.
