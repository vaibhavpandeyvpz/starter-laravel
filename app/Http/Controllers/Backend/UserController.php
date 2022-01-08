<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class);
    }

    public function index()
    {
        return view('backend.users.index');
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $exists = User::query()
            ->where('email', $data['email'])
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'email' => __('validation.unique', ['attribute' => 'email']),
            ]);
        }
        $data['password'] = Hash::make($data['password']);
        $data['enabled'] = $data['enabled'] ?? false;
        /** @var User $user */
        $user = User::query()->create($data);
        if (Gate::check('viewAny', Role::class)) {
            $user->syncRoles(Role::query()->whereIn('id', $data['roles'] ?? [])->get());
        }
        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
        flash()->success(__('User ":name" has been added to system.', ['name' => $user->name]));

        return redirect()->route('backend.users.show', $user);
    }

    public function show(User $user)
    {
        return view('backend.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->validated();
        $exists = User::query()
            ->where('email', $data['email'])
            ->whereKeyNot($user->getKey())
            ->exists();
        if ($exists) {
            throw ValidationException::withMessages([
                'email' => __('validation.unique', ['attribute' => 'email']),
            ]);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $data['enabled'] = $data['enabled'] ?? false;
        $user->fill($data);
        if ($changed = $user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        if (Gate::check('viewAny', Role::class)) {
            $user->syncRoles(Role::query()->whereIn('id', $data['roles'] ?? [])->get());
        }
        if ($changed && $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
        flash()->success(__('User ":name" information has been updated.', ['name' => $user->name]));

        return redirect()->route('backend.users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        flash()->info(__('User ":name" has been deleted from system.', ['name' => $user->name]));

        return redirect()->route('backend.users.index');
    }
}
