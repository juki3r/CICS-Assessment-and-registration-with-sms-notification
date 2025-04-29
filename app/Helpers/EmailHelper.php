<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\GeneralNotification;

if (!function_exists('sendGeneralEmail')) {
    function sendGeneralEmail($to, $subject, $message)
    {
        Mail::to($to)->send(new GeneralNotification($subject, $message));
    }
}
