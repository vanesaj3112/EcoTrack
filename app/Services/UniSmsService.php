<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class UniSmsService
{
    public function send(
        string $mobileNumber,
        string $message
    ): array {
        $response = Http::withBasicAuth(
            config('services.unisms.api_key'),
            ''
        )->post(
            rtrim(config('services.unisms.api_url'), '/') . '/sms',
            [
    'recipient' => $mobileNumber,
    'sender_id' => config('services.unisms.sender_id'),
    'content' => $message,
]
        );

        if ($response->failed()) {
            throw new RuntimeException(
                'UniSMS request failed: ' . $response->body()
            );
        }

        return $response->json();
    }
}