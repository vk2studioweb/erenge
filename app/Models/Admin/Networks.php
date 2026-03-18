<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Networks extends Model
{
    protected $table = 'vpu_networks';
    protected $primaryKey = 'id_network';
    protected $fillable = ['name', 'link', 'icon', 'api_key', 'print_list', 'description'];
}