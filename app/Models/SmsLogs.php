<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLogs extends Model
{
    protected $fillable = ['name', 'mobile_number', 'message', 'status', 'course'];
}
