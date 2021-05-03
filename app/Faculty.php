<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = [
        'nameFacultad'
    ];

    public function administrativeUnit(){
        return $this->hasOne(AdministrativeUnit::class);
    }
}
