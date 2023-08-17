<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateOrAssignAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

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
        $data['name'] = text(
            "User's full name",
            placeholder: 'E.g. VPZ',
            required: true
        );

        $data['email'] = text(
            'Their email address (new or existing)',
            required: true,
            validate: fn (string $value) => match (true) {
                filter_var($value, FILTER_VALIDATE_EMAIL) === false => 'The email must be a valid email address.',
                default => null,
            }
        );

        $password = password(
            'Password as secret as memories',
            required: true,
            validate: fn (string $value) => match (true) {
                strlen($value) < 8 => 'Password must be at least 8 characters.',
                default => null,
            }
        );

        password(
            'The same password once again, just for confirmation',
            required: true,
            validate: fn (string $value) => match (true) {
                $value !== $password => 'Password confirmation does not match',
                default => null,
            }
        );

        $data['password'] = Hash::make($password);
        $data['enabled'] = true;

        /** @var User $user */
        $user = User::query()
            ->updateOrCreate(['email' => $data['email']], $data);
        $user->syncRoles(Role::all());
        $user->touch();

        $this->info('User has been successfully added. They can now login at: '.route('login'));
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
