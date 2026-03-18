<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Navgroupmenuthumb extends Model
{
    protected $table = 'vpr_nav_group_menu_thumb';
    protected $fillable = ['id_menu', 'height', 'width', 'storange_name', 'cut'];
}
