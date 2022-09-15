<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Models\BasicSetting;

class LoginRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         $captcha=BasicSetting::select('is_recaptcha')->first();
        $data= [
            'username' => 'required',
            'password' => 'required',
        ];

        if ( isset($captcha->is_recaptcha) && $captcha->is_recaptcha==1) {
            $data['g-recaptcha-response']="required";
        }

        return $data;
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'password.required' => 'Password is required',
            'g-recaptcha-response.required' => 'Recaptcha is required',
            'g-recaptcha-response.captcha' => 'Invalid Recaptcha',
           
        ];
    }

}
