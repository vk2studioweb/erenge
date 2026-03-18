<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OutrosContatos extends Model
{
    protected $table      = 'vpu_outros_contatos';
    protected $primaryKey = 'id_outro_contato';
    protected $fillable   = [
        'nome',
        'orden',
        'telefone',
        'botao',
        'link'
    ];
}
