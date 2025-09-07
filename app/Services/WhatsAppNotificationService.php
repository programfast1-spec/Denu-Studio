<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use App\Libraries\Whatsapp\Fonnte\Fonnte;
use Carbon\Carbon;

class WhatsAppNotificationService
{
    private $fonnte;

    public function __construct()
    {
        $this->fonnte = new Fonnte(null);
    }

    public function sendAttendanceNotification(Attendance $attendance, string $type)
    {
        $user = $attendance->user;
        
        if ($type === 'check_in') {
            $message = "✅ *Absen Masuk Berhasil*\n\n";
            $message .= "👤 Nama: {$user->name}\n";
            $message .= "📅 Tanggal: " . Carbon::parse($attendance->attendance_date)->format('d/m/Y') . "\n";
            $message .= "🕐 Waktu Masuk: " . Carbon::parse($attendance->check_in_time)->format('H:i') . "\n";
            $message .= "📍 Lokasi: GPS Terverifikasi\n\n";
            $message .= "Selamat bekerja! 💪";
        } else {
            $message = "🏁 *Absen Pulang Berhasil*\n\n";
            $message .= "👤 Nama: {$user->name}\n";
            $message .= "📅 Tanggal: " . Carbon::parse($attendance->attendance_date)->format('d/m/Y') . "\n";
            $message .= "🕐 Waktu Pulang: " . Carbon::parse($attendance->check_out_time)->format('H:i') . "\n";
            $message .= "📍 Lokasi: GPS Terverifikasi\n\n";
            $message .= "Terima kasih atas kerja keras hari ini! 🙏";
        }

        return $this->fonnte->sendMessage([
            'destination' => $user->phone,
            'message' => $message,
            'delay' => 1
        ]);
    }

    public function sendLateNotification(Attendance $attendance)
    {
        $user = $attendance->user;
        
        $message = "⚠️ *Pemberitahuan Keterlambatan*\n\n";
        $message .= "👤 Nama: {$user->name}\n";
        $message .= "📅 Tanggal: " . Carbon::parse($attendance->attendance_date)->format('d/m/Y') . "\n";
        $message .= "🕐 Waktu Masuk: " . Carbon::parse($attendance->check_in_time)->format('H:i') . "\n";
        $message .= "📝 Status: Terlambat\n\n";
        $message .= "Harap lebih memperhatikan waktu kedatangan. Terima kasih.";

        return $this->fonnte->sendMessage([
            'destination' => $user->phone,
            'message' => $message,
            'delay' => 1
        ]);
    }

    public function sendCheckoutWithReportNotification(Attendance $attendance, array $reports)
    {
        $user = $attendance->user;
        
        $message = "📊 *Laporan Harian & Absen Pulang*\n\n";
        $message .= "👤 Nama: {$user->name}\n";
        $message .= "📅 Tanggal: " . Carbon::parse($attendance->attendance_date)->format('d/m/Y') . "\n";
        $message .= "🕐 Waktu Pulang: " . Carbon::parse($attendance->check_out_time)->format('H:i') . "\n\n";
        
        $message .= "📋 *Laporan Aktivitas Hari Ini:*\n";
        
        $hasReport = false;
        foreach ($reports as $report) {
            if ($report['quantity'] > 0) {
                $message .= "• {$report['type']}: {$report['quantity']}\n";
                $hasReport = true;
            }
        }
        
        if (!$hasReport) {
            $message .= "• Tidak ada aktivitas yang dilaporkan\n";
        }
        
        $message .= "\n✨ Terima kasih atas dedikasi dan kerja keras hari ini!";

        return $this->fonnte->sendMessage([
            'destination' => $user->phone,
            'message' => $message,
            'delay' => 1
        ]);
    }
}