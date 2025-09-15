<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotif extends Model
{
    protected $table = 'admin_notif';
    protected $fillable = ['action', 'actor',  'marked'];
}
