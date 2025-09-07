<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Str;

class QrCodeController extends Controller
{
    public function show()
    {
        $today = now()->toDateString();
        $qrTokenKey = 'qr_token_' . $today;

        // Cari token untuk hari ini, kalau belum ada buat baru
        $setting = Setting::firstOrCreate(
            ['key' => $qrTokenKey],
            ['value' => Str::random(40)]
        );

        $qrToken = $setting->value;

        return view('admin.qrcode.show', compact('qrToken'));
    }

    /**
     * Manual regenerate token hari ini (dari tombol).
     */
    public function regenerate()
    {
        $today = now()->toDateString();
        $qrTokenKey = 'qr_token_' . $today;

        $setting = Setting::updateOrCreate(
            ['key' => $qrTokenKey],
            ['value' => Str::random(40)]
        );

        return redirect()->route('admin.qrcode.show')->with('success', '✅ Token berhasil digenerate ulang.');
    }

    /**
     * Dipanggil otomatis oleh scheduler setiap hari jam 00:00.
     */
    public function generateDailyToken()
    {
        $today = now()->toDateString();
        $qrTokenKey = 'qr_token_' . $today;

        Setting::updateOrCreate(
            ['key' => $qrTokenKey],
            ['value' => Str::random(40)]
        );
    }
}
