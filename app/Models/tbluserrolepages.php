<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbluserrolepages extends Model
{
    use HasFactory;

      const user_page_id=3;
    const project_page_id=5;
    const location_page_id=8;
    const survey_page_id=7;
    const surveyforms_page_id=6;
    const projectcategory_page_id=4;
    const userrole_page_id=1;
      public function page()
   {
      return $this->belongsTo('\App\Models\tbluserrolepages','userroleid','id');
   }
}
