<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Texts extends Model
{
    protected $table = 'vpu_texts';
    protected $primaryKey = 'id_text';

    protected $fillable = [
        'info_location',
        'name',
        'description',
        'status'
    ];
}