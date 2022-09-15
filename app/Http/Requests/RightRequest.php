<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class RightRequest extends FormRequest
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
        $id    = !empty($input['id']) ? $input['id'] : "";
        return [
            'name' => 'required|checkRightExist:'.$id.'',
            'module_id' => 'required',
            

        ];
    }

     public function messages()
    {
        return [
            'name.required' => 'Right Name is required',
            'module_id.required' => 'Select atleast one module',
            'name.check_right_exist' => 'Right already exist',
           
        ];
    }
}
