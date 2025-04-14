<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'name_of_student',
        'activity',
        'status',
        'task',
        'course',
    ];

    
}
