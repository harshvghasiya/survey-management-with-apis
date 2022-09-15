<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblprojectlocations extends Model
{
    use HasFactory;

     public function projects()
    {
    	
    	return $this->belongsTo('\App\Models\tblprojects','project_id','id');
    }

     public function locations()
    {
    	
    	return $this->belongsTo('\App\Models\tbllocations','location_id','id');
    }
}
