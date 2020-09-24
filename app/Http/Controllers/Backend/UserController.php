<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        $data['password'] = Hash::make($data['password']);
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
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user->fill($data);
        $user->save();
        flash()->success(__('User ":name" information has been updated.', ['name' => $user->name]));
        return redirect()->route('backend.users.show', $user);
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            flash()->warning(__('You must not delete yourself from system.'));
            return redirect()->route('backend.users.show', $user);
        } else {
            $user->delete();
            flash()->info(__('User ":name" was delete from system.', ['name' => $user->name]));
            return redirect()->route('backend.users.index');
        }
    }
}
