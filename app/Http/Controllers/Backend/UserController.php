<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        if ($data['role'] === 'admin' && !Gate::check('administer')) {
            throw ValidationException::withMessages([
                'role' => __('Only existing administrator may assign "admin" role.'),
            ]);
        }
        $data['password'] = Hash::make($data['password']);
        $data['enabled'] = $data['enabled'] ?? false;
        $user = User::query()->create($data);
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
        if ($data['role'] === 'admin' && !Gate::check('administer')) {
            throw ValidationException::withMessages([
                'role' => __('Only existing administrator may assign "admin" role.'),
            ]);
        }
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $data['enabled'] = $data['enabled'] ?? false;
        if ($user->id === Auth::id() && !$data['enabled']) {
            throw ValidationException::withMessages([
                'enabled' => __('You must not disable yourself.'),
            ]);
        }
        $user->fill($data);
        if ($user->id === Auth::id() && Gate::check('administer') && !$user->can('administer')) {
            throw ValidationException::withMessages([
                'role' => __('You must not remove "admin" role from yourself.'),
            ]);
        }
        $user->save();
        flash()->success(__('User ":name" information has been updated.', ['name' => $user->name]));
        return redirect()->route('backend.users.show', $user);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            flash()->warning(__('You must not delete yourself from system.'));
            return redirect()->back();
        } else {
            $user->delete();
            flash()->info(__('User ":name" was delete from system.', ['name' => $user->name]));
            return redirect()->route('backend.users.index');
        }
    }
}
