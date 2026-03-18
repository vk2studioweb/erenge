<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {
    protected $table = 'vpu_address';
    protected $primaryKey = 'id_address';
    protected $fillable = ['address', 'celphone', 'mail', 'coords'];
}
