<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Banners extends Model
{
    protected $table = 'vpu_banner';
    protected $primaryKey = 'id_banner';

    protected $fillable = [
        'name', 'link', 'order', 'description', 'status'
    ];
}