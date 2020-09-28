<?php

namespace App\Http\Requests;

use App\Rules\UserPassword;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'birthday.before_or_equal' => __('You must be at least 18 years old.'),
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'password' => ['nullable', 'required_with:new_password', 'string', 'min:8', 'max:32', new UserPassword],
            'new_password' => ['nullable', 'string', 'min:8', 'max:32', 'confirmed'],
            'birthday' => [
                'nullable',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
            ],
            'timezone' => ['required', 'string', 'timezone'],
        ];
    }
}
