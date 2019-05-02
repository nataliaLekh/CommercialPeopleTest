# README #
### FOOTBALL TEAM API ###
* In this project we use docker to run local environment
    
### Setup ###

* Clone this repository:
```
git clone git@bitbucket.org:Nata_l/team-api.git
```

* Run:
```
$ composer install
```
* Create `.env` file based on `.env.dist`
* Generate ssh key for JWT:

```
$ mkdir config/jwt
$ ssh-keygen -t rsa -b 4096 -f jwt/rsa_256 # Hit enter for all questions
$ openssl rsa -in jwt/rsa_256 -pubout -outform PEM -out jwt/rsa_256.pub
```

* Run `docker-compose build`
* Run `docker-compose up` if you use Linux, or
`docker-compose -f docker-compose-mac.yml up` if MacOS

* Run next scripts to create database:
```
$ docker exec -it commercialpeopletest_php_1 php /src/www/team-api.local/bin/console doctrine:database:create
$ docker exec -it commercialpeopletest_php_1 php /src/www/team-api.local/bin/console doctrine:database:create -e test
$ docker exec -it commercialpeopletest_php_1 php /src/www/team-api.local/bin/console doctrine:schema:update --force
$ docker exec -it commercialpeopletest_php_1 php /src/www/team-api.local/bin/console doctrine:schema:update --force -e test
```

#### Postman collection with all endpoints ####
* Import postman collection from `/postman` folder.
* After registration request you will get token, which you need to put in header as `Authorization` with `Bearer ` prefix.

### Testing ###

For running UnitTest you need to go into php docker container:
```
docker exec -it commercialpeopletest_php_1 /bin/bash
```

After, in the project root folder you are able run tests:
```
$ cd /src/www/team-api.local/
$ vendor/bin/phpunit 
```