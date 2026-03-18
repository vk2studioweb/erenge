<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Obras extends Model
{
    protected $table      = 'vpu_obras';
    protected $primaryKey = 'id_obra';
    protected $fillable   = [
        'servico_id',
        'nome',
        'descricao',
        'local_obra',
        'coordenada',
        'detalhes',
        'status',
        'delete',
    ];
}
