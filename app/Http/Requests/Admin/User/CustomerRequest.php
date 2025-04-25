<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'first_name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'last_name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'mobile' => ['required', 'digits:11', 'unique:users'],
                'email' => ['required', 'string', 'email', 'unique:users'],
                'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
                'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
                'status' => 'required|numeric|in:0,1',
            ];
        } else {
            return [
                'first_name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'last_name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
                'profile_photo_path' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            ];
        }
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => __('validation.custom.password.required'),
            'password.min' => __('validation.custom.password.min'),
            'password.letters' => __('validation.custom.password.letters'),
            'password.mixed' => __('validation.custom.password.mixed'),
            'password.numbers' => __('validation.custom.password.numbers'),
            'password.symbols' => __('validation.custom.password.symbols'),
            'password.uncompromised' => __('validation.custom.password.uncompromised'),
            'password.confirmed' => __('validation.custom.password.confirmed'),
        ];
    }
}
