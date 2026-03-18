<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class TextBusiness extends Model
{
    protected $table = 'vpu_textbusiness';
    protected $primaryKey = 'id_textbusiness';

    protected $fillable = [
        'info_location',
        'name',
        'description',
        'status'
    ];
}