# vaibhavpandeyvpz/laravel-crud

Quick, Laravel LTS CRUD boilerplate using livewire with RBAC. Has better default auth views based on Bootstrap, nicely
integrates Select2 & Flatpickr as well.

## Installation

To create a new project from this boilerplate, run below command in Command Prompt, PowerShell or Terminal window:

```shell
composer create-project vaibhavpandeyvpz/laravel-crud:@dev <your-project-name>
```

To run the project, you can either start a local web server or run it inside a [Docker](https://www.docker.com/) container.
The ready-made `docker-compose` configuration includes [NGINX](https://www.nginx.com/), [PHP](https://www.php.net/), [MariaDB](https://mariadb.org/) and [Redis](https://redis.io/) by default.

### Local

Edit the `.env` file with your database information and seed the database with seeds by running below commands:

```shell
php artisan migrate --seed
```

Start the built-in development server using below command:

```shell
php artisan serve
```

Now open the project URL (i.e., [http://localhost:8000](http://localhost:8000) by default) in your favorite web browser and register for an account.
Then assign newly created user with administrator privileges by running below command with its email:

```shell
php artisan app:assign-admin <email-address-of-the-user>
```


### Docker

You must make below changes to `.env` to be able to get up and running with [Docker](https://www.docker.com/):

```shell
DB_HOST=mariadb
REDIS_HOST=redis
```

To start the application, run below command in Command Prompt, PowerShell or Terminal window:

```shell
docker-compose up
```

The `php` container also includes `composer` for you to carry out common tasks.
Some basic examples are below:

```shell
# install PHP dependencies
docker-compose exec php composer install

# set application secret key
docker-compose exec php php artisan key:generate

# run migrations and seed database
docker-compose exec php php artisan migrate --seed
```

## Backend

Lastly, you may access the backend at [http://localhost:8000/backend](http://localhost:8000/backend).
