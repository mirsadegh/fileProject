<?php

namespace Modules\User\Repositories;

use Carbon\Carbon;
use Modules\User\Entities\Otp;
use Modules\User\Entities\User;


class UserRepo
{
    public function findOtpByToken($token)
    {
        return Otp::where('token', $token)->firstOrFail();
    }

    public function findOtpByTokenUsedTime($token)
    {
       return Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->first();
    }

    public function findOtpByTokenforResend($token)
    {
       return Otp::where('token',$token)->where('created_at','<=',Carbon::now()->subMinutes(5)->toDateTimeString())->first();
    }

    public function findOrCreateUserByEmail($email)
    {
      $user =  User::where('email',$email)->firstOrCreate(
            ['email'      => $email],
            ['password'   => '98355154'],
            ['activation' => 1],
        );
      return $user;
    }

    public function findUserByMobileOrCreate($emailOrMobile)
    {
       $user =  User::where('mobile',$emailOrMobile)->firstOrCreate(
            ['mobile'      => $emailOrMobile],
            ['password'   => '98355154'],
            ['activation' => 1],
        );
       return $user;
    }

    public function otpCreate($otpInputs)
    {
        Otp::create($otpInputs);
    }

    public function getTeachers()
    {
       return User::Permission('teach')->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);

    }
}
