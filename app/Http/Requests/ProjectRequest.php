<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class ProjectRequest extends FormRequest
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
            'projectname' => 'required|checkProjectExist:'.$id.'',
            'category' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'estimation' => 'required',
        ];
    }

    public function messages()
    {

        return [
            'projectname.required' => 'Project Name is required',
            'category.required' => 'Category is required',
            'startdate.required' => 'Startdate is required',
            'enddate.required' => 'Enddate is required',
            'projectname.check_project_exist' => 'Project name already exist',
            'estimation'=>'Estimation Time is required'
        ];
    }
}
