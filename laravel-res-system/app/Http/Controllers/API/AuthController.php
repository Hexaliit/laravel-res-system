<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SmsCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function sendSms(Request $request){
        $mobile = $request->input('mobile');
        $checkedLastMinute = SmsCode::twoMinutesCheck($mobile);

        if (!$checkedLastMinute){
            $code = mt_rand(11111,99999);
            SmsCode::createSmsCode($mobile , $code);
            return response()->json([
                'result' => true,
                'message' => 'code sent to mobile number',
                'data' => [
                    'mobile' => $mobile,
                    'code' => $code
                ],
            ],201);

        } else {
            return response()->json([
                'result' => false,
                'message' => 'Please wait for two minutes',
                'data' => [],
            ],403);
        }
    }

    public static function verifySms(Request $request){
        $mobile = $request->input('mobile');
        $code = $request->input('code');


        $check = SmsCode::checkSend($mobile , $code);


        if ($check){
            $user = User::query()->where('mobile' , $mobile)->first();
            if ($user){
                return response()->json([
                    'result' => true,
                    'message' => 'This user is already registered',
                    'data' => [
                        'id' => $user->id,
                        'token' => $user->createToken("newToken")->plainTextToken
                    ],
                ],200);
            } else {
                $user = User::query()->create([
                    'mobile' => $mobile,
                    'password' => Hash::make(mt_rand(11111,99999))
                ]);
                dd($user);
                return response()->json([
                    'result' => true,
                    'message' => 'User registered successfully',
                    'data' => [
                        'id' => $user->id,
                        'token' => $user->createToken("newToken")->plainTextToken
                    ],
                ],201);

            }
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Invalid code',
                'data' => [],
            ],403);
        }
    }
}
