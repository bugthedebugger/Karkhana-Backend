<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use App\Model\Role;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Model\Registration;
use App\Model\UserInfo;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }

    public function registration() {
        return $this->hasOne(Registration::class);
    }

    public function info() {
        return $this->hasOne(UserInfo::class);
    }

    public function passwordResetToken() {
        return $this->hasOne('App\Model\PasswordResetToken');
    }
}
