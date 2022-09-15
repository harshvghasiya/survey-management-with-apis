<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ModuleRequest extends FormRequest
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
            'name' => 'required|checkModuleExist:'.$id.'',
            

        ];
    }


    public function messages()
    {

        return [
            'name.required' => 'Module Name is required',
            'name.check_module_exist' => 'Module name already exist',
           
        ];
    }
}
