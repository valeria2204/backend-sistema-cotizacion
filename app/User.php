<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Role;
use App\AdministrativeUnit;
use App\SpendingUnit;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','lastName','phone','direction','ci', 'email','userName','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class)
                    ->withPivot('id','administrative_unit_id','spending_unit_id','role_status','administrative_unit_status','spending_unit_status','global_status')
                    ->withTimestamps();
    }

    public function spendingUnit(){
        //return $this->belongsTo(SpendingUnit::class);
        return $this->belongsToMany(SpendingUnit::class)
                    ->withPivot('id','role_id','administrative_unit_id','role_status','administrative_unit_status','spending_unit_status','global_status')
                    ->withTimestamps();
    }

    public function administrativeUnit(){
        //return $this->belongsTo(AdministrativeUnit::class);
        return $this->belongsToMany(AdministrativeUnit::class)
                    ->withPivot('id','role_id','spending_unit_id','role_status','administrative_unit_status','spending_unit_status','global_status')
                    ->withTimestamps();
    }
}
