<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblprojectusers extends Model
{
    use HasFactory;


     public function projects()
    {
    	
    	return $this->belongsTo('\App\Models\tblprojects','project_id','id');
    }

     public function users()
    {
    	
    	return $this->belongsTo('\App\Models\tblusers','user_id','id');
    }
}
