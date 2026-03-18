<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MailConfig extends Model
{
    protected $table = 'vpr_configuration_mail';
    protected $primaryKey = 'id_configuration';
    protected $fillable = ['smtp', 'ssl', 'mail_send', 'password_mail_send','smtp_port'];

}

    
