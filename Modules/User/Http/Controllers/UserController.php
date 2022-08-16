<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Modules\User\Repositories\UserRepo;
use Illuminate\Contracts\Support\Renderable;
use Modules\User\Http\Requests\UpdateProfileInformationRequest;

class UserController extends Controller
{

    public function profile()
    {
        $this->authorize('editProfile', User::class);
        return view('user::Front.profile');
    }

    public function updateProfile(UpdateProfileInformationRequest $request,UserRepo $userRepo)
    {
        $this->authorize('editProfile', User::class);
        $userRepo->updateProfile($request);

        return back()->with(['swal-success'=>'پروفایل با موفقیت برروزرسانی گردید.']);
    }

    public function info($user, UserRepo $repo)
    {
        $this->authorize('index', User::class);
        $user = $repo->FindByIdFullInfo($user);
        return view("user::admin.info", compact("user"));
    }

}
