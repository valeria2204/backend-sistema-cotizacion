<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Permission;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nameRol','description'
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function permissions(){
        return $this->belongsToMany(Permission::class);
    }
}
