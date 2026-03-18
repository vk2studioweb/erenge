<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Navgroupmenuchildren extends Model
{
    protected $primaryKey = "id_menu_children";
    protected $table = 'vpr_nav_group_menu_children';
    protected $fillable = ['id_menu', 'name', 'link', 'default'];
}
