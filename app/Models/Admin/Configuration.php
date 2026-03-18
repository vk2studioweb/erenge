<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $table = 'vpr_configuration';
    protected $primaryKey = 'id_configuration';
    protected $fillable = ['name','keywords','analytics', 'mail','description'];
}
