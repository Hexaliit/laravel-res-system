<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class SmsCode extends Model
{
    use HasFactory;

    public $fillable = ['mobile' , 'code'];

    public static function twoMinutesCheck($mobile){

        $check = Self::query()->where('mobile' , $mobile)
            ->where('created_at', '>' , Carbon::now()->subMinutes(2))->first();

        if ($check){
            return true;
        }
        return false;

    }

    public static function createSmsCode($mobile , $code){
        Self::query()->create([
            'mobile' => $mobile,
            'code' => $code
        ]);
    }

    public static function checkSend($mobile , $code){
        $checked = Self::query()->where([
            'mobile' => $mobile,
            'code' => $code
        ])->first();
        if ($checked){
            return true;
        }
        return false;
    }
}
