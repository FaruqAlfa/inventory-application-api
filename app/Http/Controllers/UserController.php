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
            'message' => 'Profile data successfully retrieved'
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string',
            'age' => 'required|integer',
            'gender' => 'required|string',
            'phone' => 'required|string',
        ]);

        $user = User::findOrFail($id);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'gender' => $request->gender,
            'phone' => $request->phone
        ]);

        return response()->json([
            'status' => true,
            'data' => ['id' => $user->id],
            'message' => 'Profile updated successfully'
        ]);
    }
}
