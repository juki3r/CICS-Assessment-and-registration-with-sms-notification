<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = [
        'fullname',
        'address',
        'contact_number',
        'school',
        'strand',
        'age',
        'exam',
        'interview',
        'skill_test',
        'gwa',
        'total',
        'student_course',
    ];
}
