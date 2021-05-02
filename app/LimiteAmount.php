<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LimiteAmount extends Model
{
    public function AdministrativeUnit(){
        return $this->belongsTo(AdministrativeUnit::class);
    }
}
