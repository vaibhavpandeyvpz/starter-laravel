<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

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
    protected $description = 'Sets "admin" role to specified email address.';

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
        $user = User::query()
            ->where('email', $this->argument('email'))
            ->firstOrFail();
        $user->role = 'admin';
        $user->save();
    }
}
