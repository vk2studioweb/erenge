<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Filiais extends Model
{
    protected $table      = 'vpu_filiais';
    protected $primaryKey = 'id_filial';
    protected $fillable   = [
        'nome',
        'endereco',
        'coordenada',
        'cep',
        'orden',
        'telefone',
        'email',
        'descricao',
        'status',
        'delete',
    ];
}
