<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Navgroup extends Model
{
    protected $table = 'vpr_nav_group';
    protected $primaryKey = 'id_nav_group';
    protected $fillable = ['name', 'link', 'submenu'];
}