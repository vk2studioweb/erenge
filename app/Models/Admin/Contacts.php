<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'vpu_contacts';
    protected $primaryKey = 'id_contact';
    protected $fillable = ['name', 'celphone', 'mail', 'city', 'uf', 'description'];
}
