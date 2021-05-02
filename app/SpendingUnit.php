<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AdministrativeUnit;

class SpendingUnit extends Model
{
    //
    protected $fillable = [
        'nameUnidadGasto','administrative_units_id'
    ];

    public function admnistrativeUnits(){
        return $this->belongsTo(AdministrativeUnit::class);
    }
}
