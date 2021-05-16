<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Faculty;
use App\LimiteAmount;
use App\Quotitation;
use App\User;

class AdministrativeUnit extends Model
{
    protected $fillable = [
        'name','faculties_id','faculty'
    ];
    public function quotitation(){
        return $this->hasMany(Quotitation::class);
    }

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function limiteAmount(){
        return $this->hasMany(LimiteAmount::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }

}
