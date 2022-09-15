<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RightModule extends Model
{
    use HasFactory;

     public function module_data()
    {
      return $this->belongsTo('\App\Models\Module','module_id','id');
    }
}
