<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMS
{
    protected $apiUrl = 'https://sms.pong-mta.tech/api/send-sms-api';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('PONG_SMS_TOKEN', 'your_default_token_here');
    }

    public function sendsms($phoneNumber, $message)
    {
        if (!$this->apiKey) {
            return ['success' => false, 'error' => 'API key is not configured'];
        }

        $response = Http::withHeaders([
            'X-API-KEY' => $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, [
            'phone_number' => $phoneNumber,
            'message' => $message,
        ]);

        if ($response->failed()) {
            return [
                'success' => false,
                'error' => 'Failed to send message',
                'details' => $response->body(),
            ];
        }

        return ['success' => true, 'response' => $response->json()];
    }
}
