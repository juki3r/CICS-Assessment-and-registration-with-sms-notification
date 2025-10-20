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
        'interview_result',
        'skilltest',
        'total',
        'remarks',
        'actual_result',
        'sent'
    ];

    // Hook into saving event
    protected static function booted()
    {
        static::saving(function ($registration) {
            $exam       = $registration->exam_result;
            $gwa        = $registration->gwa;
            $interview  = $registration->interview_result;
            $skilltest  = $registration->skilltest;

            // Only calculate if all values are not null
            if (!is_null($exam) && !is_null($gwa) && !is_null($interview) && !is_null($skilltest)) {
                $registration->total = round(($exam + $gwa + $interview + $skilltest), 2);

                $registration->remarks = $registration->total >= 75 ? 'Passed' : 'Failed';
            }
        });
    }
}
