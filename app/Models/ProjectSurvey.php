<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectSurvey extends Model
{
	protected $table="tblproject_survey";
    use HasFactory;



     public function projects()
    {
    	
    	return $this->belongsTo('\App\Models\tblprojects','project_id','id');
    }

     public function survey()
    {
    	
    	return $this->belongsTo('\App\Models\tblsurveys','survey_id','id');
    }
}
