<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Noticias extends Model
{
    protected $table      = 'vpu_noticias';
    protected $primaryKey = 'id_noticia';
    protected $fillable   = [
        'nome',
        'descricao',
        'abreviacao',
        'direitos',
        'imagem',
        'autor',
        'status',
        'delete',
    ];
}
