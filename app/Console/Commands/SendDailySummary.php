<?php

namespace App\Console\Commands;

use App\Services\WhatsAppNotificationService;
use Illuminate\Console\Command;

class SendDailySummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:send-daily-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily attendance summary to WhatsApp group';

    private $whatsappService;

    /**
     * Create a new command instance.
     */
    public function __construct(WhatsAppNotificationService $whatsappService)
    {
        parent::__construct();
        $this->whatsappService = $whatsappService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Sending daily attendance summary...');
        
        $result = $this->whatsappService->sendDailySummary();
        
        if ($result) {
            $this->info('Daily summary sent successfully to WhatsApp group');
        } else {
            $this->warn('No attendance data found for today or failed to send summary');
        }

        return Command::SUCCESS;
    }
}