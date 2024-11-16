<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserProfileController extends Controller
{
    public function getProfile(): JsonResponse
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = Auth::user();
        $patient = Patient::where('id', $user->id)->first();

        return response()->json([
            'success' => true,
            'profile' => [
                'name' => $user->name,
                'email' => $user->email,
                'tanggal_lahir' => $user->tanggal_lahir,
                'profile_image' => $user->profile_image ? asset('storage/' . $user->profile_image) : null,
                'no_telp' => $user->no_telp,
                'Alamat' => $user->Alamat,
                'age' => $user->age
            ]
        ]);
    }
}
