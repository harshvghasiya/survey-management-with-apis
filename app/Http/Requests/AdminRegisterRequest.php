<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class AdminRegisterRequest extends FormRequest
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
    public function rules(Request $r)
    {
      
            
            $input = $r->all();
             $id = !empty($input['id']) ? $input['id'] : "";

        $data= [
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'username' => 'required|checkUsernameExitAdminUser:' . $id . '',
            'right_id' => 'required',
            'image'=>'nullable|mimes:jpg,jpeg,png'
            

        ];

         if (isset($id) && !empty($id)) {

            if (isset($input['change_password']) && $input['change_password'] == 1) {

                $data['password'] = "required|min:6";
            }

        } else {

            $data['password'] = "required|min:6";
        }

        return $data;
        
    }


    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'username.required' => 'Username is required',
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'phone_number.required' => 'Phone Number is required',
            'email.email' => 'Not Valid email type',
            'right_id.required'=> 'Select Admin Right',
            'password.required' => 'Password is required',
            'password.min' => 'Password length is 6',
            'username.check_username_exit_admin_user' => 'Username already exist',

           
        ];
    }
}
