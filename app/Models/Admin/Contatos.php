<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Contatos extends Model
{
    protected $table      = 'vpu_contatos';
    protected $primaryKey = 'id_contato';
    protected $fillable   = [
        'nome',
        'email',
        'telefone',
        'cidade',
        'descricao',
        'status',
        'delete',
    ];
}
