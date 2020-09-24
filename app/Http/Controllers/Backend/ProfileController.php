<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('backend.profile');
    }

    public function update(ProfileRequest $request)
    {
        $user = $request->user();
        $data = $request->validated();
        if (empty($data['new_password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['new_password']);
        }
        $user->fill($data);
        if ($changed = $user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();
        if ($changed && $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
        flash(__('Your profile details were successfully updated.'))->success();
        return view('backend.profile');
    }
}
