<?php

namespace App\Http\Controllers;

use App\Models\PhoneVerification;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

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
        $checkEmail = Users::where('email', $request->email)->first();
        $checkPhone = Users::where('phone', $request->phone)->first();
        if ($checkEmail) {
            return response()->json(['alert' => 'البريد الإلكتروني موجود مسبقا'], 401);
        } elseif ($checkPhone) {
            return response()->json(['alert' => 'رقم الهاتف موجود مسبقا'], 401);
        }
        $user = Users::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'token' => bin2hex(random_bytes(40)),
            'phone_verified' => 0,
        ]);
        $phone_verify = PhoneVerification::create([
            'user_id' => $user->id,
            'code' => rand(1000, 9999),
            'expire' => now()->addMinutes(30),
        ]);
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($request->phone, ['from' => $twilio_number, 'body' => 'كود التحقق الخاص بك هو ' . $phone_verify->code . '\n صلاحية الكود 30 دقيقة فقط']);
        $response = [
            'message' => 'تم تسجيل الحساب بنجاح',
            'user' => $user,
        ];
        return $response;
    }
}
