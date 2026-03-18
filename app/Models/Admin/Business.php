<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table = 'vpu_business';
    protected $primaryKey = 'id_business';
    protected $fillable = ['name', 'description'];
}