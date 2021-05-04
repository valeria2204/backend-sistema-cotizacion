<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RequestQuotitation; 

class CompanyCode extends Model
{
       /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code','email','request_quotitations_id','details'
    ];
    public function requestQuotitation(){
        return $this->belongsTo(RequestQuotitation::class);
    }
}
