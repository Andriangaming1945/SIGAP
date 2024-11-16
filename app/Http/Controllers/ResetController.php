<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\ResetPasswordMail;
use DB;
use Carbon\Carbon;


class ResetController extends Controller
{
    public function sendResetCode(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required'
            ]);

            $user = User::where('email', $request->email)
                       ->where('name', $request->name)
                       ->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Generate random 6 digit code
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Save reset code to database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $code,
                    'created_at' => Carbon::now()
                ]
            );

            // Send email
            Mail::to($request->email)->send(new ResetPasswordMail($code));

            return response()->json([
                'status' => 'success',
                'message' => 'Kode reset password telah dikirim ke email Anda'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyResetCode(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'reset_code' => 'required|string|size:6'
            ]);

            $passwordReset = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('token', $request->reset_code)
                ->first();

            if (!$passwordReset) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode reset password tidak valid'
                ], 400);
            }

            // Check if code is expired (60 minutes)
            if (Carbon::parse($passwordReset->created_at)->addMinutes(60)->isPast()) {
                DB::table('password_reset_tokens')
                    ->where('email', $request->email)
                    ->delete();

                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode reset password telah kedaluwarsa'
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Kode reset password valid'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'reset_code' => 'required|string|size:6',
                'password' => 'required|string|min:8|confirmed'
            ]);

            $passwordReset = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('token', $request->reset_code)
                ->first();

            if (!$passwordReset) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode reset password tidak valid'
                ], 400);
            }

            // Update password
            $user = User::where('email', $request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();

            // Delete reset code
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil diubah'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
