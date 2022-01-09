# vaibhavpandeyvpz/starter-laravel

Quick, [Laravel](https://laravel.com/) LTS CRUD boilerplate using [Livewire](https://laravel-livewire.com/) with [RBAC](https://spatie.be/docs/laravel-permission/v3/introduction).
Has better default auth views based on [Bootstrap](https://getbootstrap.com/docs/4.6/getting-started/introduction/), nicely integrates [Select2](https://select2.org/) and [Flatpickr](https://flatpickr.js.org/) as well.

## Installation

Before installing, make sure to have [PHP](https://www.php.net/), [Composer](https://getcomposer.org/), [Node.js](https://nodejs.org/en/), [Yarn](https://yarnpkg.com/) and either of [MySQL](https://www.mysql.com/) or [MariaDB](https://mariadb.org/) installed on your workstation.

To create a new project from this template, run below command in Command Prompt, PowerShell or Terminal window:

```shell
composer create-project vaibhavpandeyvpz/starter-laravel:@dev <your-project-name>
```

To run the project, you can either start a local web server or run it inside a [Docker](https://www.docker.com/) container.

## Local

Edit the `.env` file with your database information and seed the database with seeds by running below commands:

```shell
php artisan migrate --seed
```

Start the built-in development server using below command:

```shell
php artisan serve
```

## Docker

This project also includes pre-configured [Docker](https://www.docker.com/) scripts for faster development as well as deployment.

### Prepare

Before you start the project with [Docker](https://www.docker.com/), you need to update below values in `.env` file:

```
APP_URL=http://localhost:8080

DB_HOST=mariadb
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret

REDIS_HOST=redis

QUEUE_CONNECTION=redis

AWS_ACCESS_KEY_ID=accessKey1
AWS_SECRET_ACCESS_KEY=verySecretKey1
AWS_BUCKET=laravel
AWS_ENDPOINT=http://zenko:8000
AWS_ENDPOINT_PATH_STYLE=true
```

### Development

To start the application, run below command in Command Prompt, PowerShell or Terminal window:

```shell
docker-compose up -d
```

The `web` container also includes `composer` for you to carry out common tasks, some basic examples are below:

```shell
# install any PHP package
docker-compose exec web composer require <package-name>

# run migrations and seed database
docker-compose exec web php artisan migrate --seed
```

Before you start to use the bundled S3-compatible cloud storage, you will need to create the bucket as follows:

```shell
# open a shell
docker-compose exec web sh

# start a tinker session
php artisan tinker

# copy/paste and run below PHP code
$client = Storage::cloud()->getAdapter()->getClient();
$result = $client->createBucket(['Bucket' => config('filesystems.disks.s3.bucket')]);
```

### Deployment

To build an image for deployment and publish the image to a registry e.g., [Docker Hub](https://hub.docker.com/), use command as below:

```shell
# build and tag image
docker build -t vaibhavpandeyvpz/starter-laravel .

# push image to registry
docker push vaibhavpandeyvpz/starter-laravel
```

## Backend

Lastly, you may access the backend at [http://localhost:8000/](http://localhost:8000/) or [http://localhost:8080/](http://localhost:8080/) (if using Docker) in your favorite web browser and register for an account.
Then assign newly created user with administrator privileges by running below command with its email:

```shell
# if developing locally
php artisan app:assign-admin <email-address-of-the-user>

# if using Docker
docker-compose exec web php artisan app:assign-admin <email-address-of-the-user>
```

## Best practices

To enforce recommended coding style across project, this project also includes configuration for [PHP CS Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer) be default.
Before committing your changes, you may run below command to test your code against any such issue.

```shell
# if developing locally
./vendor/bin/php-cs-fixer fix --show-progress=dots -vvv

# if using Docker
docker-compose exec web vendor/bin/php-cs-fixer fix --show-progress=dots -vvv
```
