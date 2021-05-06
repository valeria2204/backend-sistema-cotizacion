<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpendingUnit extends Model
{
    //
    protected $fillable = [
        'nameUnidadGasto','faculties_id', 'faculty', 'administrativeUnit',
    ];

    public function faculties(){
        return $this->belongsTo(Faculty::class);
    }
}
