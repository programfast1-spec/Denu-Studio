<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Absensi;
use App\Libraries\Whatsapp\Fonnte\Fonnte;

class AbsensiController extends Controller
{
    public function scan(Request $request)
    {
        // 1. Cari user berdasarkan QR Code
        $user = User::where('qr_code', $request->qr_code)->first();

        if (!$user) {
            // Buat user sementara untuk demo
            $user = (object)[
                'id'    => 1,
                'name'  => 'admin',
                'phone' => '6282118549655'
            ];
            return response()->json(['status' => 'error', 'message' => 'QR Code tidak valid']);
        }

        // 2. Simpan absensi
        Absensi::create([
            'user_id' => $user->id,
            'waktu'   => now(),
            'status'  => 'hadir',
        ]);

        // 3. Kirim WA via Fonnte
        $fonnte = new Fonnte(null);

        $response = $fonnte->sendMessage([
            'destination' => $user->phone, // pastikan kolom phone ada di tabel users
            'message'     => "Halo {$user->name}, absensi Anda tercatat pada " . now()->format('d-m-Y H:i'),
            'delay'       => 1
        ]);

        // 4. Return response
        return response()->json([
            'status'   => 'ok',
            'message'  => 'Absensi berhasil & WA terkirim',
            'wa'       => $response
        ]);
    }
}
