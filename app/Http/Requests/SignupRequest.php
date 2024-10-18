<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name"=> "required|string|max:100",
            "email"=> ["required","email",Rule::unique("users","email")->withoutTrashed()],
            "phone"=> ["required","string","max:11",Rule::unique("users","phone")->withoutTrashed()],
            "password"=> ["required","string","min:8","max:50","confirmed","regex:/[a-z]/", "regex:/[A-Z]/", "regex:/[0-9]/","regex:/[@$!%*?&#]/"],
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];
    }
}
