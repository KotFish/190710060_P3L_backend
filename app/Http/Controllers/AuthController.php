<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Pelanggan;
use App\Models\Pengemudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email:filter'],
            'password' => ['required', 'string']
        ]);

        $user = Pegawai::firstWhere('email', $data['email']);

        if ($user === null) {
            $user = Pengemudi::firstWhere('email', $data['email']);

            if ($user === null) {
                $user = Pelanggan::firstWhere('email', $data['email']);

                if ($user === null) {
                    return response()->json([
                        'message' => 'Email tidak terdaftar.'
                    ], 401);
                }
                else {
                    $ability = 'Pelanggan';
                }
            }
            else {
                $ability = 'Pengemudi';
            }
        }
        else {
            $ability = $user->jabatan;
        }

        if (Hash::check($data['password'], $user->password) === false) {
            return response()->json([
                'message' => 'Password tidak sesuai.'
            ], 401);
        }

        return response()->json([
            'message' => 'Login berhasil.',
            'token' => $user->createToken($request->header('User-Agent'), [$ability])->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil.'
        ]);
    }
}
