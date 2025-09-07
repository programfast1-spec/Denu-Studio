<?php

namespace App\Libraries\Whatsapp\Fonnte;

class FonnteBulkMessage
{
    private array $messageWhatsapp = [];

    public function __construct(public array $messages)
    {
        foreach ($messages as $message) {
            $destination = $message['destination'] ?? '120363403583974447@g.us'; // default ke grup
            $text = $message['message'] ?? '';
            $delay = $message['delay'] ?? 1;

            if (!is_string($destination) || trim($destination) === '') {
                error_log("Destination kosong, skip pesan: $text");
                continue;
            }

            $messageObj = new FonnteMessage($destination, $text, $delay);

            try {
                $success = $messageObj->send();
                if ($success) {
                    error_log("Pesan terkirim ke $destination: $text");
                } else {
                    error_log("Gagal mengirim ke $destination: $text");
                }
            } catch (\Exception $e) {
                error_log("Exception saat kirim ke $destination: " . $e->getMessage());
            }

            $this->messageWhatsapp[] = $messageObj->toArray();
        }
    }

    public function toArray(): array
    {
        return $this->messageWhatsapp;
    }

    public function toJson(): string
    {
        return json_encode($this->messageWhatsapp);
    }
}
