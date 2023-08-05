<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateOrAssignAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:make-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new admin user or assigns administrator permissions to an existing user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data['name'] = $this->ask('Name');
        while (true) {
            $email = $this->ask('Email address');
            if (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) {
                $data['email'] = $email;
                break;
            }

            $this->error('Please enter a valid email address.');
        }

        while (true) {
            $password = $this->secret('Password');
            if (empty($password) || strlen($password) < 8) {
                $this->error('Password must be at least 8 characters.');

                continue;
            }

            $confirmation = $this->secret('Confirm password');
            if ($password !== $confirmation) {
                $this->error('Password confirmation does not match');

                continue;
            }

            $data['password'] = Hash::make($password);
            break;
        }

        $data['enabled'] = true;

        /** @var User $user */
        $user = User::query()
            ->updateOrCreate(['email' => $data['email']], $data);
        $user->syncRoles(Role::all());

        $this->info('User has been successfully added. You can login at: '.route('login'));
        $this->table(
            ['name', 'email address'],
            [
                [
                    'name' => $user->name,
                    'email address' => $user->email,
                ],
            ]
        );
    }
}
