<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function getAdmins()
    {
        return Admins::all();
    }
    public function createAdmin(Request $request)
    {
        Admins::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'token' => bin2hex(random_bytes(40)),
        ]);
    }
    public function deleteAdmin($id)
    {
        return Admins::where('id', $id)->delete();
    }
    public function login(Request $request)
    {
        $checkEmail = Admins::where('email', $request->email)->first();
        if ($checkEmail) {
            if (Hash::check($request->password, $checkEmail->password)) {
                return $checkEmail;
            } else {
                return response()->json(['alert' => 'كلمة المرور غير صحيحة'], 401);
            }
        } else {
            return response()->json(['alert' => 'المستخدم غير موجود'], 401);
        }
    }
    public function updateProfile(Request $request)
    {
        $update = Admins::where('token', $request->header('Authorization'))->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        return Admins::where('token', $request->header('Authorization'))->first();
    }
    public function updatePassword(Request $request)
    {
        Admins::where('token', $request->header('Authorization'))->update([
            'password' => Hash::make($request->new_password),
        ]);
    }
}
