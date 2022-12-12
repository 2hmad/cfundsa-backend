<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use App\Models\Followers;
use App\Models\Notifications;
use App\Models\PhoneVerification;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Twilio\Rest\Client;

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
    public function editProfilePassword(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        if ($user !== null) {
            if (Hash::check($request->current, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->new),
                ]);
                return response()->json([
                    'alert' => 'تم تغيير كلمة المرور بنجاح'
                ], 200);
            } else {
                return response()->json([
                    'alert' => 'كلمة المرور الحالية غير صحيحة'
                ], 400);
            }
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
            $generate_code = PhoneVerification::where('user_id', $user->id)->update([
                'code' => rand(1000, 9999),
                'expire' => now()->addMinutes(30),
            ]);
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_AUTH_TOKEN");
            $twilio_number = getenv("TWILIO_NUMBER");
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($user->phone, ['from' => $twilio_number, 'body' => 'كود التحقق الخاص بك هو ' . $generate_code->code . '
صلاحية الكود 30 دقيقة فقط']);
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
    public function verifyEmail($token)
    {
        $checkCode = EmailVerification::where([
            ['token', $token],
        ])->first();
        if ($checkCode !== null) {
            $checkCode->delete();
            return response()->json([
                'alert' => 'تم تأكيد البريد الالكتروني بنجاح'
            ], 200);
        } else {
            return response()->json([
                'alert' => 'الكود غير صحيح'
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
    public function getNotifications(Request $request)
    {
        $user = Users::where('token', $request->header('Authorization'))->first();
        if ($user !== null) {
            return Notifications::where([
                ['user_id', $user->id]
            ])->orderBy('read', 'ASC')->get();
        } else {
            return response()->json([
                'alert' => 'هذا المستخدم غير موجود'
            ], 400);
        }
    }
    public function readNotification($id)
    {
        $notification = Notifications::where('id', $id)->first();
        if ($notification !== null) {
            $notification->update([
                'read' => 1,
            ]);
            return response()->json([
                'alert' => 'تم تحديد الاشعار كمقروء'
            ], 200);
        } else {
            return response()->json([
                'alert' => 'هذا الاشعار غير موجود'
            ], 400);
        }
    }
}
