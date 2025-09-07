<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\WhatsAppNotificationService;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{
    private $whatsappService;

    public function __construct(WhatsAppNotificationService $whatsappService)
    {
        $this->whatsappService = $whatsappService;
    }

    /**
     * Display WhatsApp management page
     */
    public function index()
    {
        return view('admin.whatsapp.index');
    }

    /**
     * Get QR Code for device connection
     */
    public function getQrCode()
    {
        $result = $this->whatsappService->getQrCode();
        return response()->json($result);
    }

    /**
     * Check device connection status
     */
    public function checkStatus()
    {
        $result = $this->whatsappService->checkDeviceStatus();
        return response()->json($result);
    }

    /**
     * Send test message
     */
    public function sendTestMessage(Request $request)
    {
        $target = $request->input('target');
        $result = $this->whatsappService->sendTestMessage($target);
        
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Pesan test berhasil dikirim']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Gagal mengirim pesan test']);
    }

    /**
     * Send daily summary manually
     */
    public function sendDailySummary()
    {
        $result = $this->whatsappService->sendDailySummary();
        
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Rekap harian berhasil dikirim']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Tidak ada data absensi hari ini atau gagal mengirim']);
    }

    /**
     * Send device status to group
     */
    public function sendDeviceStatus()
    {
        $status = $this->whatsappService->checkDeviceStatus();
        $message = "📱 *STATUS PERANGKAT WHATSAPP*\n\n";
        
        if (isset($status['device']) && $status['device']['status'] === 'connect') {
            $message .= "✅ Status: Terhubung\n";
            $message .= "📞 Nomor: {$status['device']['number']}\n";
        } else {
            $message .= "❌ Status: Tidak Terhubung\n";
            $message .= "⚠️ Perlu scan QR Code ulang\n";
        }
        
        $message .= "\n_Sistem Absensi SIMPEG_";
        
        $result = $this->whatsappService->sendMessage(config('services.fontte.group_id'), $message);
        
        if ($result) {
            return response()->json(['status' => 'success', 'message' => 'Status perangkat berhasil dikirim']);
        }
        
        return response()->json(['status' => 'error', 'message' => 'Gagal mengirim status perangkat']);
    }
}