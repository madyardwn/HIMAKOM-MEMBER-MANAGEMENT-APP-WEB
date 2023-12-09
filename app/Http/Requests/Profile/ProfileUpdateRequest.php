<?php

namespace App\Http\Requests\Profile;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Return an array of validation rules for the request.
     */
    public function rules()
    {
        return [
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
        ];
    }

    /**
     * Return an array of custom messages for validation rules.
     */
    public function messages()
    {
        return [
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        if ($this->password == null) {
            $this->request->remove('password');
        }
    }
}
