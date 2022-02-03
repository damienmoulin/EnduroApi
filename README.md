# Diligencio


## API Documentation
* URL: [http://localhost:8080/doc](http://localhost:8080/doc)
* URL: [http://localhost:8080/doc.json](http://localhost:8080/doc.json)


### Requirement
* PHP 7..4



## Lancer l'application
> make install

> make migrate

> make start

## PhpPgAdmin
* URL: [http://localhost:11080/](http://localhost:11080/)
* Username : root
* Password: root

## App
* URL: [http://api.enduro.wip:11082/login](http://api.enduro.wip:11082/login)

### Api Documentation
* URL: [http://localhost:8080/api/doc.json](http://localhost:8080/api/doc.json)

## Phinx

### Create Migration
Documentation: [https://book.cakephp.org/phinx/0/en/migrations.html#creating-a-new-migration](https://book.cakephp.org/phinx/0/en/migrations.html#creating-a-new-migration)
> make createMigration migration=MyMigration


### Create Seed
Documentation: [https://book.cakephp.org/phinx/0/en/seeding.html#creating-a-new-seed-class](https://book.cakephp.org/phinx/0/en/seeding.html#creating-a-new-seed-class)
> make createSeed seed=MySeed

## Help
> make help

## Workflow
bin/console workflow:dump movement | dot -Tpng -o movement_workflow.png
