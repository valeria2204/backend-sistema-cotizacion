<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpendingUnit extends Model
{
    //
    protected $fillable = [
<<<<<<< HEAD
        'nameUnidadGasto','administrative_units_id', 'faculty'
=======
        'nameUnidadGasto','faculties_id', 'faculty', 'administrativeUnit',
>>>>>>> da12a8484d5257f49698a30989c6187e0e819bc7
    ];

    public function faculties(){
        return $this->belongsTo(Faculty::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
    public function requestQuotitations(){
        return $this->hasMany(RequestQuotitation::class);
    

    
}
