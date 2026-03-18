<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Beneficios extends Model
{
    protected $table      = 'vpu_beneficios';
    protected $primaryKey = 'id_beneficio';
    protected $fillable   = [
        'nome',
        'descricao',
        'orden',
        'status',
        'delete',
    ];
}
