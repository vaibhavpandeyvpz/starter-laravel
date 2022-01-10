<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProfileRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

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
        if ($data['photo_remove'] ?? false) {
            $data['photo'] = null;
            $old_photo = $user->photo;
        } elseif (empty($data['photo'])) {
            unset($data['photo']);
        } else {
            /** @var UploadedFile $photo */
            $photo = $data['photo'];
            $image = Image::make($photo)->fit(256)->encode('png');
            $name = sprintf('users/%d/photos/%s.png', $user->id, Str::random(10));
            Storage::disk('public')->put($name, (string) $image);
            $data['photo'] = $name;
            unlink($photo->getRealPath());
            $old_photo = $user->photo;
        }
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
        if (isset($old_photo)) {
            Storage::disk('public')->delete($old_photo);
        }
        if ($changed && $user instanceof MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
        flash(__('Your profile details were successfully updated.'))->success();

        return redirect()->route('backend.profile');
    }
}
