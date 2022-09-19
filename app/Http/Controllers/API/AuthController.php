<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('nama', $request->nama)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Akses ditolak. Silahkan cek nama dan password kembali!'
            ], 401);
        }

        $token = $user->createToken('token')->plainTextToken;

        // return ApiResponse::onlyEntity([
        //     'user' => collect($user)->only(['username'])->toArray(),
        //     'permissions' => $permissions,
        //     'roles' => $roles,
        //     'token' => $token,
        // ]);
        return response()->json([
            'message' => 'Berhasil Login',
            'token' => $token
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            "message" => 'Berhasil Logout'
        ], 200);
    }
}
