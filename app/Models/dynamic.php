<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dynamic extends Model
{
    use HasFactory;

    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }
}
