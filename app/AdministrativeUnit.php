<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Faculty;
use App\LimiteAmount;
use App\Quotitation;
use App\User;
use App\SpendingUnit;
use App\Role;

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
        return $this->belongsToMany(User::class)
                    ->withPivot('role_id','spending_unit_id','role_status','administrative_unit_status','spending_unit_status')
                    ->withTimestamps();
    }

    public function spendingUnits(){
        return $this->belongsToMany(SpendingUnit::class)
                    ->withPivot('user_id','role_id','role_status','administrative_unit_status','spending_unit_status')
                    ->withTimestamps();
    }

    public function roles(){
        return $this->belongsToMany(Role::class)
                    ->withPivot('user_id','spending_unit_id','role_status','administrative_unit_status','spending_unit_status')
                    ->withTimestamps();
    }

}
