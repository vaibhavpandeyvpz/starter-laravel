<?php

namespace App\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserPassword implements Rule
{
    private Authenticatable $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Authenticatable $user = null)
    {
        $this->user = $user ?: Auth::user();
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        return Hash::check($value, $this->user->getAuthPassword());
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return trans('auth.failed');
    }
}
