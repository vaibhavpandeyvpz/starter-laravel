# vaibhavpandeyvpz/laravel-crud

Quick, Laravel LTS CRUD boilerplate using livewire with RBAC. Has better default auth views based on Bootstrap, nicely
integrates Select2 & Flatpickr as well.

### Installation

To create a new project from this boilerplate, run below command in Command Prompt, PowerShell or Terminal window:

```shell
composer create-project vaibhavpandeyvpz/laravel-crud:@dev <your-project-name>
```

Then edit the `.env` file with your database information and seed the database with seeds by running below commands:

```shell
php artisan migrate --seed
```

Now open the project URL (e.g., [http://localhost:8000](http://localhost:8000) if using built-in `php artisan serve` command) in your favorite web browser and register for an account.
Then assign newly created user with administrator privileges by running below command with its email:

```shell
php artisan app:assign-admin <email-address-of-the-user>
```

Lastly, you may access the backend at [http://localhost:8000/backend](http://localhost:8000/backend).
