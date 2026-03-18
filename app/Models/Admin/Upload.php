<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'vpr_nav_group_menu_upload';
    protected $primaryKey = 'id_upload';
    protected $fillable = ['id_menu', 'id_register', 'extension', 'name', 'description', 'author', 'image_rights', 'order', 'hash_temp'];
}
