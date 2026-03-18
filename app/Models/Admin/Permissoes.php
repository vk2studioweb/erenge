<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Permissoes extends Model
{
    protected $table = 'vpr_permission';
    protected $primaryKey = 'id_permission';
    protected $fillable = ['id_menu', 'id_group', 'id_user', 'view', 'edit', 'add', 'upload'];
}