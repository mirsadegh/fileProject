<?php

namespace Modules\User\Repositories;

use Carbon\Carbon;
use Modules\User\Entities\Otp;
use Modules\User\Entities\User;
use Modules\RolePermission\Entities\Permission;


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
            ['password'   => bcrypt('98355154')],
        );
        return $user;
    }

    public function findUserByMobileOrCreate($emailOrMobile)
    {
        $user =  User::where('mobile', $emailOrMobile)->firstOrCreate(
            ['mobile'      => $emailOrMobile],
            ['password'   => bcrypt('98355154')],

        );
        return $user;
    }

    public function otpCreate($otpInputs)
    {
        return Otp::create($otpInputs);
    }

    public function getTeachers()
    {
        return User::Permission(['teach','super_admin'])->get();
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

        return User::where('id', $userId)->update($update);
    }

    public function updateProfile($request)
    {
        auth()->user()->name = $request->name;
        auth()->user()->telegram = $request->telegram;
        if (auth()->user()->email != $request->email) {
            auth()->user()->email = $request->email;
            auth()->user()->email_verified_at = null;
        }

        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)) {
            auth()->user()->card_number = $request->card_number;
            auth()->user()->shaba = $request->shaba;
            auth()->user()->headline = $request->headline;
            auth()->user()->bio = $request->bio;
            auth()->user()->username = $request->username;
        }

        if ($request->password) {
            auth()->user()->password = bcrypt($request->password);
        }

        auth()->user()->save();
    }

    public function FindByIdFullInfo($id)
    {
        return User::query()
            ->where("id", $id)
            ->with("settlements", "payments", "courses" ,"purchases")
            ->firstOrFail();
    }
}
