<?php

namespace App\Http\Controllers;

use App\Models\Followers;
use App\Models\PhoneVerification;
use App\Models\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUserInfo($id)
    {
        return Users::where('id', $id)->with(['followers', 'comments'])->first();
    }
    public function followUser(Request $request)
    {
        $checkFollow = Followers::where([
            ['user_id', $request->user_id],
            ['follower_id', $request->follower_id]
        ])->first();
        if ($checkFollow == null) {
            Followers::create([
                'user_id' => $request->user_id,
                'follower_id' => $request->follower_id
            ]);
        } else {
            return response()->json([
                'alert' => 'لقد قمت بمتابعة هذا المستخدم من قبل'
            ], 400);
        }
    }
    public function unFollowUser(Request $request)
    {
        $checkFollow = Followers::where([
            ['user_id', $request->user_id],
            ['follower_id', $request->follower_id]
        ])->first();
        if ($checkFollow !== null) {
            $checkFollow->delete();
        } else {
            return response()->json([
                'alert' => 'لم تقم بمتابعة هذا المستخدم من قبل'
            ], 400);
        }
    }
    public function editProfile(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        if ($user !== null) {
            if ($request->phone !== $user->phone) {
                if (Users::where('phone', $request->phone)->first() !== null) {
                    return response()->json([
                        'alert' => 'رقم الهاتف موجود مسبقاً'
                    ], 400);
                }
                $checkVerify = PhoneVerification::where('user_id', $user->id)->first();
                if ($checkVerify !== null) {
                    $checkVerify->delete();
                }
                PhoneVerification::create([
                    'user_id' => $user->id,
                    'code' => rand(1000, 9999),
                    'expire' => now()->addMinutes(30),
                ]);
                $user->phone_verified = 0;
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
        } else {
            return response()->json([
                'alert' => 'هذا المستخدم غير موجود'
            ], 400);
        }
    }
    public function changeImage(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        if ($user !== null) {
            $validate = $request->validate([
                'image' => 'required|mimes:jpg,png,jpeg|max:1000'
            ]);
            if ($validate) {
                $image_name = $user->id . '.' . $request->image->getClientOriginalExtension();
                $image_path = $request->file('image')->storeAs('users', $image_name, 'public');
                $user->update([
                    'image' => '/storage/users/' . $image_name,
                ]);
                return response()->json([
                    'alert' => 'تم تغيير الصورة بنجاح',
                    'image' => '/storage/users/' . $image_name,
                ], 200);
            }
        } else {
            return response()->json([
                'alert' => 'هذا المستخدم غير موجود'
            ], 400);
        }
    }
    public function resendCode(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        if ($user !== null) {
            PhoneVerification::where('user_id', $user->id)->update([
                'code' => rand(1000, 9999),
                'expire' => now()->addMinutes(30),
            ]);
            return response()->json([
                'alert' => 'تم إعادة إرسال الكود بنجاح'
            ], 200);
        } else {
            return response()->json([
                'alert' => 'هذا المستخدم غير موجود'
            ], 400);
        }
    }
    public function verifyPhone(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        if ($user !== null) {
            $checkCode = PhoneVerification::where([
                ['user_id', $user->id],
                ['code', $request->code],
            ])->first();
            if ($checkCode !== null) {
                if ($checkCode->expire > now()) {
                    $user->update([
                        'phone_verified' => 1,
                    ]);
                    $checkCode->delete();
                    return response()->json([
                        'alert' => 'تم تفعيل الهاتف بنجاح'
                    ], 200);
                } else {
                    return response()->json([
                        'alert' => 'انتهت صلاحية الكود'
                    ], 400);
                }
            } else {
                return response()->json([
                    'alert' => 'هذا الكود غير صحيح'
                ], 400);
            }
        } else {
            return response()->json([
                'alert' => 'هذا المستخدم غير موجود'
            ], 400);
        }
    }
    public function getAllUsers()
    {
        return Users::orderBy('id', 'DESC')->get();
    }
    public function deleteUser($id)
    {
        return Users::where('id', $id)->delete();
    }
}
