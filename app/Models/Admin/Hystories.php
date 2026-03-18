<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Hystories extends Model
{
    protected $table = 'vpu_hystories';
    protected $primaryKey = 'id_history';

    protected $fillable = [
        'name',
        'age',
        'age_detail',
        'age_icon',
        'treatment',
        'treatment_detail',
        'treatment_icon',
        'urgency',
        'urgency_detail',
        'urgency_icon',
        'description',
        'status'
    ];
}