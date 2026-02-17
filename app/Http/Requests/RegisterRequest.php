<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

class RegisterRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:64',
            'last_name' => 'required|string|max:64',
            'email' => 'required|string|email|max:64|unique:users,email',
            'phone' => 'required|string|max:32|unique:users,phone',
            'password' => 'required|string|min:6',
        ];
    }
}
