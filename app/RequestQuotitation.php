<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RequestDetail; 
use App\Report; 
use App\CompanyCode;

class RequestQuotitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
<<<<<<< HEAD
        'nameUnidadGasto','aplicantName','requestDate','details','amount','spending_units_id'
=======
        'nameUnidadGasto','aplicantName','requestDate','details','amount','amountIsHigher'
>>>>>>> da12a8484d5257f49698a30989c6187e0e819bc7
    ];

    public function requestDetails(){
        return $this->hasMany(RequestDetail::class);
    }
    public function reports(){
        return $this->hasMany(Report::class);
    }
    public function companyCodes(){
        return $this->hasMany(CompanyCode::class);
    }

    public function spendingUnits(){
        return $this->belongsTo(SpendingUnit::class);
    }
    

}
