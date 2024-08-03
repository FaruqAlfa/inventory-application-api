<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function getProfile()
    {
        return response()->json([
            'status' => true,
            'data' => Auth::user(),
            'message' => 'Data profil berhasil diambil'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'usia' => 'required|integer',
        ]);

        // Perbarui informasi pengguna
        $user->name = $request->name;
        $user->email = $request->email;

        // Perbarui password jika diberikan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->usia = $request->usia;

        // Simpan perubahan
        $user->save();

        return response()->json([
            'status' => true,
            'data' => ['id' => $user->id],
            'message' => 'Profil berhasil diperbarui'
        ]);
    }
}
