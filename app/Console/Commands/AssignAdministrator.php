<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

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
    protected $description = 'Sets "Administrator" role to specified email address.';

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
        $user->save();
        return 0;
    }
}
