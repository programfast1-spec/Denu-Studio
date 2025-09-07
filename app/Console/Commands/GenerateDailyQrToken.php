<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateDailyQrToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-daily-qr-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new QR token for daily attendance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->toDateString();
        $qrTokenKey = 'qr_token_' . $today;

        // Generate new token
        $newToken = Str::random(40);
        
        // Update or create setting
        Setting::updateOrCreate(
            ['key' => $qrTokenKey],
            ['value' => $newToken]
        );

        $this->info("Daily QR token generated successfully for {$today}");
        $this->info("Token: {$newToken}");

        return Command::SUCCESS;
    }
}