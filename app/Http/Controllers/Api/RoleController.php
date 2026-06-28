<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => Role::all()]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        $role = Role::create($validated);

        return response()->json(['data' => $role], 201);
    }

    public function show(Role $role): JsonResponse
    {
        return response()->json(['data' => $role]);
    }

    public function update(Request $request, Role $role): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,'.$role->id,
        ]);

        $role->update($validated);

        return response()->json(['data' => $role]);
    }

    public function destroy(Role $role): JsonResponse
    {
        $role->delete();

        return response()->noContent();
    }
}
