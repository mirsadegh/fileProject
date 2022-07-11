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
        return Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(5)->toDateTimeString())->firstOrFail();
    }

    public function findOtpByTokenforResend($token)
    {
        return Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinutes(5)->toDateTimeString())->firstOrFail();
    }

    public function findOrCreateUserByEmail($email)
    {
        $user =  User::where('email', $email)->firstOrCreate(
            ['email'      => $email],
            ['password'   => '98355154'],
            ['activation' => 1],
        );
        return $user;
    }

    public function findUserByMobileOrCreate($emailOrMobile)
    {
        $user =  User::where('mobile', $emailOrMobile)->firstOrCreate(
            ['mobile'      => $emailOrMobile],
            ['password'   => '98355154'],
            ['activation' => 1],
        );
        return $user;
    }

    public function otpCreate($otpInputs)
    {
        return Otp::create($otpInputs);
    }

    public function getTeachers()
    {
        return User::Permission('teach')->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function paginate()
    {
        return User::paginate();
    }

    public function update($userId, $values)
    {
        $update = [
            'name' => $values->name,
            'email' => $values->email,
            'mobile' => $values->mobile,
            'username' => $values->username,
            'headline' => $values->headline,
            'status' => $values->status,
            'bio' => $values->bio,
            'image_id' => $values->image_id
        ];
        if (!is_null($values->password)) {
            $update['password'] = bcrypt($values->password);
        }

        $user = User::find($userId);
        $user->syncRoles([]);
        if ($values['role'])
            $user->assignRole($values['role']);
        return User::where('id', $userId)->update($update);
    }
}
