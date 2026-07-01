<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CashierSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CashierSessionController extends Controller
{
    public function current(Request $request): JsonResponse
    {
        $session = CashierSession::open()->forUser($request->user()->id)->latest('opened_at')->first();

        return response()->json(['data' => $session]);
    }

    public function open(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'opening_cash' => 'required|numeric|min:0',
        ]);

        $existing = CashierSession::open()->forUser($request->user()->id)->exists();

        if ($existing) {
            throw ValidationException::withMessages([
                'session' => ['Anda sudah memiliki sesi yang aktif'],
            ]);
        }

        $session = CashierSession::create([
            'user_id' => $request->user()->id,
            'opening_cash' => $validated['opening_cash'],
            'opened_at' => now(),
            'status' => 'open',
        ]);

        return response()->json(['data' => $session], 201);
    }

    public function close(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'closing_cash' => 'required|numeric|min:0',
        ]);

        $session = CashierSession::open()->forUser($request->user()->id)->latest('opened_at')->first();

        if (!$session) {
            throw ValidationException::withMessages([
                'session' => ['Tidak ada sesi aktif untuk ditutup'],
            ]);
        }

        $session->update([
            'closing_cash' => $validated['closing_cash'],
            'closed_at' => now(),
            'status' => 'closed',
        ]);

        return response()->json(['data' => $session]);
    }

    public function history(Request $request): JsonResponse
    {
        $sessions = CashierSession::forUser($request->user()->id)
            ->orderBy('opened_at', 'desc')
            ->get();

        return response()->json(['data' => $sessions]);
    }
}
