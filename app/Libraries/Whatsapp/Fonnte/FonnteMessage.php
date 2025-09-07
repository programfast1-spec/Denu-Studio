<?php

namespace App\Libraries\Whatsapp\Fonnte;

class FonnteMessage
{
    // Masukkan token langsung
    private string $token = 'G9TCA5qweLmBcAPrRwQd';

    public function __construct(
        public string $destination,
        public string $message,
        public int $delay = 1
    ) {}

    public function toArray(): array
    {
        return [
            'destination' => $this->destination,
            'message' => $this->message,
            'delay' => $this->delay,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    // Fungsi kirim pesan ke WhatsApp via Fontte API
    public function send(): bool
    {
        $data = [
            'destination' => $this->destination,
            'message' => $this->message,
        ];

        $ch = curl_init('https://api.fontte.com/sendMessage');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        sleep($this->delay); // Delay antar pesan

        return $httpCode === 200;
    }
}
