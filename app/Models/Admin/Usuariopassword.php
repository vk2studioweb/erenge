<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Usuariopassword extends Model
{
    protected $table = 'vpr_login_users';
    protected $primaryKey = 'id_login_user';
    protected $fillable = ['id_class', 'id_permission', 'name', 'email', 'password', 'remember_token'];

}
