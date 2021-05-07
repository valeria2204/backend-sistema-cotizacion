<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AdministrativeUnit;

class SpendingUnit extends Model
{
    //
    protected $fillable = [
        'nameUnidadGasto','administrative_units_id', 'faculty'
    ];

    public function admnistrativeUnits(){
        return $this->belongsTo(AdministrativeUnit::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
    public function requestQuotitations(){
        return $this->hasMany(RequestQuotitation::class);
    

    
}
