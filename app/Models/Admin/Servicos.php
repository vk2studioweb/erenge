<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    protected $table      = 'vpu_servicos';
    protected $primaryKey = 'id_servico';
    protected $fillable   = [
        'nome',
        'descricao',
        'order',
        'status',
        'delete',
    ];
}
