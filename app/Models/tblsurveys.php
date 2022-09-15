<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class tblsurveys extends Model
{
    use HasFactory;

    public function getNextId() 
	{
     	$statement = DB::raw("show table status like 'tblsurveys'");
     	return $statement[0]->Auto_increment;
	}

	public function survey_type()
    {
    	return $this->belongsTo('\App\Models\tblsurveytypes','surveytype_id','id');
    }

    public function survey_form()
    {
        return $this->hasMany('\App\Models\tblsurveyforms','survey_id','id')->orderBy('survey_id','ASC');
    }

     public function survey_project()
    {
        return $this->hasMany('\App\Models\ProjectSurvey','survey_id','id');
    }
}
