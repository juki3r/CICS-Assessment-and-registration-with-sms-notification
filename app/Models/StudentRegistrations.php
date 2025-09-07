<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRegistrations extends Model
{
    protected $fillable = [
        'fullname',
        'course',
        'exam_result',
        'address',
        'contact_details',
        'gwa',
        'school',
        'strand',
        'rating_communication',
        'rating_confidence',
        'rating_thinking',
        'interview_result'
    ];
}
