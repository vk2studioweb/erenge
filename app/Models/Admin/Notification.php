<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'vpr_notifications';
    protected $primaryKey = 'id_notification';
    protected $fillable = ['title', 'message', 'icon', 'id_user'];
}
