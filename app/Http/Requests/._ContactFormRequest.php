<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Google\Recaptcha\Validation\RecaptchaValidator;

class ContactFormRequest extends FormRequest
{
    public function rules()
    {
        return [
            // Other validation rules...
            'g-recaptcha-response' => [new RecaptchaValidator],
        ];
    }
}
