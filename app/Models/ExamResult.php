<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    protected $fillable = [
        'user_id',
        'exam',
        'interview',
        'gwa',
        'skill_test',
        'remarks',
        'course'
    ];
}
