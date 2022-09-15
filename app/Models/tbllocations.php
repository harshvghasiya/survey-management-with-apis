<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbllocations extends Model
{
    use HasFactory;

    public function location_single()
    {
    	return $this->hasMany('\App\Models\tblmultilocations','locationid','id');
    }
}
