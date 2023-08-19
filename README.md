# vaibhavpandeyvpz/starter-laravel

Quick, [Laravel](https://laravel.com/) CRUD boilerplate using [Livewire](https://laravel-livewire.com/) with [RBAC](https://spatie.be/docs/laravel-permission/v3/introduction).
Uses [Docker](https://www.docker.com) for local development & production deployments, has better auth views based on [Bootstrap](https://getbootstrap.com/docs/5.3/getting-started/introduction/), nicely integrates [Select2](https://select2.org/) and [Flatpickr](https://flatpickr.js.org/) as well.

## Prepare

If you wish to use SSL for local development (recommended), you need to have [mkcert](https://github.com/FiloSottile/mkcert) installed on your machine.
Once installed, next install the [mkcert](https://github.com/FiloSottile/mkcert)'s local CA in system's trust store.

```shell
$ sudo mkcert -install
```

Then generate an SSL certificate for local development using below command:

```shell
$ mkcert local.dev '*.local.dev' localhost 127.0.0.1 ::1
```

### Installation

Before installing, make sure to have [Docker](https://www.docker.com/) installed on your workstation.
Then simply download or clone the code and run below commands in project folder:

```shell
# start the services
$ docker-compose up -d

# spawn a shell in web container
$ docker-compose exec web bash

# install dependencies
$ composer install && yarn install && yarn build

# create sample .env file
$ php -r "file_exists('.env') || copy('.env.example', '.env');"

# setup NGROK_AUTHTOKEN in .env

# set application key
$ php artisan key:generate

# initialize scout indices
$ php artisan scout:sync-index-settings

# prepare database
$ php artisan migrate --seed

# link public storage directory
$ php artisan storage:link
```

You can access the project via browser at [https://web.local.dev/](https://web.local.dev/) or [http://localhost:8000/](https://localhost:8000/).

To be able to manage users, roles etc., you must create or assign relevant roles to a user.
You can do so by running below command and providing the user information interactively:

```shell
$ php artisan make:admin
```

## Extras

[Traefik](https://traefik.io/) requires you to route hostnames to your local machine.
To do so, add the following lines to your `/etc/hosts` file:

```
127.0.0.1 cdn.local.dev
127.0.0.1 mailcatcher.local.dev
127.0.0.1 meilisearch.local.dev
127.0.0.1 minio.local.dev
127.0.0.1 phpmyadmin.local.dev
127.0.0.1 redis-commander.local.dev
127.0.0.1 web.local.dev
```

The [Docker](https://www.docker.com/) setup also include below services to ease local development:

- [MailCatcher](https://mailcatcher.me/) - to catch all outgoing emails, access on [https://mailcatcher.local.dev/](https://mailcatcher.local.dev/)
- [Meilisearch](https://www.meilisearch.com/) - a full-text search engine, access on [https://meilisearch.local.dev/](https://meilisearch.local.dev/)
- [MinIO](https://min.io/) - an S3 compatible storage, access on [https://minio.local.dev/](https://minio.local.dev/)
- [phpMyAdmin](https://www.phpmyadmin.net/) - to manage SQL database, access on [https://phpmyadmin.local.dev/](https://phpmyadmin.local.dev/)
- [Redis Commander](http://joeferner.github.io/redis-commander/) - to manage Redis data, access on [https://redis-commander.local.dev/](https://redis-commander.local.dev/)

Some additional configuration described below may be needed for extended functionality.

### File uploads

Before uploading files, you may need to log in to [MinIO](https://min.io/) console at [https://minio.local.dev/](https://minio.local.dev/) using `laraveldev` as both (username and password) and create a bucket named `laraveldev`.
Once created, go to bucket's settings and change its **Access Policy** to `Public`.

### Ngrok

The project setup also includes [ngrok](https://ngrok.com/) service. To get the active tunnel URL, use below command:

```shell
# start the services
$ docker-compose up -d

# show ngrok tunnel url
$ php artisan ngrok:discover
```

### Code-style

The project uses [laravel/pint](https://github.com/laravel/pint) to enforce code-style.
To run it and fix any issues, use below command:

```shell
$ docker run --rm -v .:/workspace syncloudsoftech/pinter
```

## Deployment

You can deploy the project into production (using [Docker](https://www.docker.com/)) using below commands:

```shell
# build production container
$ docker build -t laraveldev .

# push image to registry
$ docker push laraveldev
```
