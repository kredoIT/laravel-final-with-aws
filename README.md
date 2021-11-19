# Project Setup

### versions
```
- PHP:  7.4.22 
- Nginx: 1.18.0
- Mysql: 8.0.22
```

## FOR LINUX/MAC ENVIRONMENT

#### clone the project
```
1. $ git clone this repository
2. $ cd project
3. $ cp .env.template .env
4. $ make init
5. edit db info and app_url on backend/.env file

APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=kredo
DB_USERNAME=kredo
DB_PASSWORD=password

6. $ docker-compose exec app php artisan migrate
```

### executables
```
# up default container
$ docker-compose up -d

# build no cache and force remake container
$ docker-compose build --no-cache --force-rm

# check container
$ docker ps

# stop container
$ docker-compose stop

# remove container
$ docker-compose down

# remove all of container stuff
# docker-compose down --rmi all --volumes

# log for laravel
$ docker-compose logs

# seeding the database
$ docker-compose exec app php artisan db:seed
```

## FOR WINDOWS ENVIRONMENT

### installation

```
1. git clone this repository
2. cd project
```

#### Prioritize this change. Copy the line of code below and change the infra/mysql/Dockerfile code
```
FROM mysql:8.0.22

COPY ./my.cnf /etc/mysql/conf.d/my.cnf
RUN chmod 644 /etc/mysql/conf.d/my.cnf
```

### project setup
```
1. mkdir -p ./docker/php/bash/psysh
2. touch ./docker/php/bash/.bash_history
3. cp .env.template .env
4. winpty docker-compose build --no-cache --force-rm
5. winpty docker-compose up -d
7. cp backend/.env.example backend/.env
8. winpty docker-compose exec app composer install
9. winpty docker-compose exec app php artisan key:generate

# modify this to your ./backend/.env file 
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=kredo
DB_USERNAME=kredo
DB_PASSWORD=password


10. winpty docker-compose exec app php artisan config:cache
11. winpty docker-compose exec app chown www-data storage/ -R
12. winpty docker-compose exec app php artisan migrate
```

#### executables

```
# up default container
winpty docker-compose up -d

# build no cache and force remake container
winpty docker-compose build --no-cache --force-rm

# check container
winpty docker ps

# stop container
winpty docker-compose stop

# remove container
winpty docker-compose down

# remove all of container stuff
winpty docker-compose down --rmi all --volumes

# log for laravel
winpty docker-compose logs

# seeding the database
winpty docker-compose exec app php artisan db:seed
```

### check browser
```
web server:     http://localhost/
php my admin:   http://localhost:8888/
```

## FYI
#### create laravel project inside backend folder
```

# laravel storage log errors  / laravel storage permission [LINUX/MAC]
$ docker-compose exec app chown www-data storage/ -R
$ docker-compose exec app chmod -R 777 storage/

------------------

# laravel storage log errors  / laravel storage permission [WINDOWS]
winpty docker-compose exec app chown www-data storage/ -R
winpty docker-compose exec app chmod -R 777 storage/
```
