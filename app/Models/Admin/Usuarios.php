<?php

namespace App\Models\Admin;

use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model implements Authenticatable, CanResetPassword 
{

    use AuthenticatableTrait;
    use CanResetPasswordTrait;

    protected $table = 'vpr_login_users';
    protected $primaryKey = 'id_login_user';
    protected $fillable = ['id_class', 'id_permission', 'name', 'email', 'password', 'remember_token', 'profile_picture'];
}
