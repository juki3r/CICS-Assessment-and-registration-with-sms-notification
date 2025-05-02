<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    protected $apiUrl = 'https://sms.pong-mta.tech/api/send-sms-api'; // Replace with your actual URL
    protected $apiKey = 'ZZB2ltgk0fD2T2YyV7kvhR06fuvcNKk8Z6ifJo5U'; // Replace with subscriber's API key

    public function sendSMS($to, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'to' => $to,
            'message' => $message,
        ]);

        return $response->json(); // or ->body() if they want raw
    }
}
