<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $checkEmail = Users::where('email', $request->email)->first();
        if ($checkEmail) {
            if (Hash::check($request->password, $checkEmail->password)) {
                $response = [
                    'message' => 'Login Success',
                    'user' => $checkEmail,
                ];
                return $response;
            } else {
                return response()->json(['alert' => 'كلمة المرور غير صحيحة'], 401);
            }
        } else {
            return response()->json(['alert' => 'المستخدم غير موجود'], 401);
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'phone' => 'required|unique:users',
        ]);
        $user = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'token' => bin2hex(random_bytes(40)),
            'phone_verified' => 0,
        ]);
        PhoneVerification::create([
            'user_id' => $user->id,
            'code' => rand(1000, 9999),
            'expire' => now()->addMinutes(30),
        ]);
        $response = [
            'message' => 'تم تسجيل الحساب بنجاح',
            'user' => $user,
        ];
        return $response;
    }
}
