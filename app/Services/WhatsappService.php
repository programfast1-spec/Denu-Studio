<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsappService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('G9TCA5qweLmBcAPrRwQd');
    }

    public function send($number, $message)
    {
        return Http::withHeaders([
            'Authorization' => $this->apiKey
        ])->post('https://api.fonnte.com/send', [
            'target' => $number,   // format 62xxxxxxxx
            'message' => $message,
        ])->json();
    }
}
