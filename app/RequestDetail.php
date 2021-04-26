<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RequestQuotitation; 

class RequestDetail extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount','unitMeasure','description','request_quotitations_id'
    ];
    public function requestQuotitation(){
        return $this->belongsTo(RequestQuotitation::class);
    }

}
