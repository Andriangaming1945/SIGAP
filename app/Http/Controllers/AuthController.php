<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validasi input termasuk profile image
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'tanggal_lahir' => 'required|date',
            'no_telp' => 'required|string|max:15|unique:users|regex:/^([0-9\s\-\+\(\)]*)$/',
            'Alamat' => 'required|string|max:255',
            'password' => 'required|min:8',
            'age' => 'required'
            // Validasi gambar (opsional)
        ]);
    
        // Jika ada file profile image, simpan ke direktori 'profile_images'
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        } else {
            $imagePath = null; // Jika tidak ada gambar, set null
        }
    
        // Membuat user baru dengan profile image (jika ada)
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'no_telp' => $validatedData['no_telp'],
            'Alamat' => $validatedData['Alamat'],
            'password' => Hash::make($validatedData['password']),
            'age' => $validatedData['age'],
            'profile_image' => $imagePath, // Simpan path profile image ke database
        ]);
    
        return response()->json(['message' => 'Registration successful', 'user' => $user], 201);
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'redirect_path' => $user->role === 'admin' ? '/admin/dashboard' : '/user/dashboard'
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}
