<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Polices extends Model
{
    protected $table = 'vpu_polices';
    protected $primaryKey = 'id_police';

    protected $fillable = [
        'slug',
        'name',
        'description',
        'status'
    ];
}