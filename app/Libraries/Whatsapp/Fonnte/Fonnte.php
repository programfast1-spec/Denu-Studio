<?php

namespace App\Libraries\Whatsapp\Fonnte;

use App\Libraries\Whatsapp\Whatsapp;
use App\Libraries\Whatsapp\Fonnte\FonnteBulkMessage;

class Fonnte implements Whatsapp
{
    private string $urlApi = 'https://api.fonnte.com/send';

    public function __construct(public ?string $token = null) {}

    public function getProvider(): string
    {
        return 'Fonnte';
    }

    public function getToken(): string
    {
        return $this->token ?? env('FONTTE_TOKEN');
    }

    /**
     * @param array|string $messages
     * Struktur setiap item: ['destination' => '628xxx', 'message' => '...', 'delay' => 1]
     */
    public function sendMessage(array|string $messages): string
    {
        // Normalisasi ke array-of-messages
        if (!isset($messages[0])) {
            $messages = [$messages];
        }

        $bulk = new FonnteBulkMessage($messages);

        $sent = 0;
        $failed = 0;
        $errors = [];

        foreach ($bulk->toArray() as $msg) {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $this->urlApi,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => [
                    'target'  => $msg['destination'],
                    'message' => $msg['message'],
                    'delay'   => $msg['delay'] ?? 1,
                ],
                CURLOPT_HTTPHEADER => [
                    "Authorization: {$this->getToken()}",
                ],
                CURLOPT_TIMEOUT => 30,
            ]);

            $response = curl_exec($curl);
            if ($err = curl_error($curl)) {
                $failed++;
                $errors[] = $err;
                curl_close($curl);
                continue;
            }
            curl_close($curl);

            $decoded = json_decode($response, true);
            if (is_array($decoded) && ($decoded['status'] ?? false)) {
                $sent++;
            } else {
                $failed++;
                $errors[] = $decoded['reason'] ?? 'Unknown error';
            }
        }

        return "Sukses: {$sent}, Gagal: {$failed}" . (count($errors) ? ' | ' . implode(' ; ', array_slice($errors,0,3)) : '');
    }
}