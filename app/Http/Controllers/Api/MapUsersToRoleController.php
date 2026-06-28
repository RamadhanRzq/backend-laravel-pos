<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MapUsersToRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MapUsersToRoleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => MapUsersToRole::with('user', 'role')->get()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        $mapping = MapUsersToRole::create($validated);

        return response()->json(['data' => $mapping->load('user', 'role')], 201);
    }

    public function show(MapUsersToRole $mapUsersToRole): JsonResponse
    {
        return response()->json(['data' => $mapUsersToRole->load('user', 'role')]);
    }

    public function update(Request $request, MapUsersToRole $mapUsersToRole): JsonResponse
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $mapUsersToRole->update($validated);

        return response()->json(['data' => $mapUsersToRole->load('user', 'role')]);
    }

    public function destroy(MapUsersToRole $mapUsersToRole): JsonResponse
    {
        $mapUsersToRole->delete();

        return response()->noContent();
    }
}
