<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use App\Role;

class AssignAdministrator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync all available roles with specified user by email address.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** @var User $user */
        $user = User::query()
            ->where('email', $this->argument('email'))
            ->firstOrFail();
        $roles = Role::query()->get();
        $user->syncRoles(...$roles);

        return 0;
    }
}
