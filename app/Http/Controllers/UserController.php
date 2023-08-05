<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateOrUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateOrUpdateRequest $request)
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
        if ($user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }

        flash()->success(__('User ":name" has been added to system.', ['name' => $user->name]));

        return redirect()->route('users.show', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserCreateOrUpdateRequest $request, User $user)
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
        $user->save();
        if ($changed = $user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        if ($changed && $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }

        flash()->success(__('User ":name" information has been updated.', ['name' => $user->name]));

        return redirect()->route('users.show', $user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        flash()->info(__('User ":name" has been deleted from system.', ['name' => $user->name]));

        return redirect()->route('users.index');
    }
}
