<?php

namespace App\Http\Requests\Backend;

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
            'photo' => [
                'nullable',
                'image',
                'mimes:jpeg,png',
                'max:1024',
                'dimensions:min_width=256,min_height=256,max_width:1024,min_width:1024',
            ],
            'photo_remove' => ['sometimes', 'boolean'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'password' => ['nullable', 'required_with:new_password', 'string', 'min:8', 'max:32', new UserPassword],
            'new_password' => ['nullable', 'string', 'min:8', 'max:32', 'confirmed'],
            'birthday' => [
                'nullable',
                'date',
                'before_or_equal:' . today()->subYears(18)->format('Y-m-d'),
            ],
            'timezone' => ['required', 'string', 'timezone'],
        ];
    }
}
