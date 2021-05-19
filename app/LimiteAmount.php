<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LimiteAmount extends Model
{
    protected $fillable = [
        'monto','dateStamp','steps','administrative_units_id','limit_fin'
    ];
    public function AdministrativeUnit(){
        return $this->belongsTo(AdministrativeUnit::class);
    }
}
