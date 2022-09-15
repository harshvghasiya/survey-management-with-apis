<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblprojects extends Model
{
    use HasFactory;

    public function project_categories()
    {
    	
    	return $this->belongsTo('\App\Models\tblprojectcateogries','category_id','id');
    }

     public function project_survey()
    {	
    	return $this->belongsTo('\App\Models\tblsurveys','survey_id','id');
    }

    public function project_locations()
    {
    	
    	return $this->hasMany('\App\Models\tblprojectlocations','project_id','id');
    }

     public function project_users()
    {
    	
    	return $this->hasMany('\App\Models\tblprojectusers','project_id','id');
    }

     public function project_surveys()
    {
        
        return $this->hasMany('\App\Models\ProjectSurvey','project_id','id')->orderBy('order','ASC');
    }

      public function project_surveys_order()
    {
        
        return $this->hasMany('\App\Models\ProjectSurveyOrder','project_id','id');
    }
}
