<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SesiKasir;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SesiKasirController extends Controller
{
    public function current(Request $request): JsonResponse
    {
        $session = SesiKasir::open()->forUser($request->user()->id)->latest('waktu_saldo_awal')->first();

        return response()->json(['data' => $session]);
    }

    public function open(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'saldo_awal' => 'required|numeric|min:0',
        ]);

        $existing = SesiKasir::open()->forUser($request->user()->id)->exists();

        if ($existing) {
            throw ValidationException::withMessages([
                'sesi' => ['Anda sudah memiliki sesi yang aktif'],
            ]);
        }

        $session = SesiKasir::create([
            'user_id' => $request->user()->id,
            'saldo_awal' => $validated['saldo_awal'],
            'waktu_saldo_awal' => now(),
            'status' => 'open',
        ]);

        return response()->json(['data' => $session], 201);
    }

    public function close(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'saldo_akhir' => 'required|numeric|min:0',
        ]);

        $session = SesiKasir::open()->forUser($request->user()->id)->latest('waktu_saldo_awal')->first();

        if (!$session) {
            throw ValidationException::withMessages([
                'session' => ['Tidak ada sesi aktif untuk ditutup'],
            ]);
        }

        $session->update([
            'saldo_akhir' => $validated['saldo_akhir'],
            'waktu_saldo_akhir' => now(),
            'status' => 'closed',
        ]);

        return response()->json(['data' => $session]);
    }

    public function history(Request $request): JsonResponse
    {
        $sessions = SesiKasir::forUser($request->user()->id)
            ->orderBy('waktu_saldo_awal', 'desc')
            ->get();

        return response()->json(['data' => $sessions]);
    }
}
