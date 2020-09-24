<?php

namespace App\Rules;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserPassword implements Rule
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * Create a new rule instance.
     *
     * @param Authenticatable|null $user
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->user->getAuthPassword());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('auth.failed');
    }
}
