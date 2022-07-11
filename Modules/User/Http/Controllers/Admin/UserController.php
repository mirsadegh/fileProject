<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Modules\User\Entities\User;
use App\Http\Controllers\Controller;
use Modules\User\Repositories\UserRepo;
use Modules\RolePermission\Entities\Role;
use Modules\Common\Responses\AjaxResponses;
use Illuminate\Contracts\Support\Renderable;
use Modules\Media\Services\MediaFileService;
use Modules\User\Http\Requests\AddRoleRequest;
use Modules\RolePermission\Repositories\RoleRepo;
use Modules\User\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{

    private $userRepo;
    private $roleRepo;
    public function __construct(UserRepo $userRepo, RoleRepo $roleRepo)
    {
        $this->userRepo = $userRepo;
        $this->roleRepo = $roleRepo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->authorize('index', User::class);
        $users = $this->userRepo->paginate();
        $roles = $this->roleRepo->all();
        return view('user::admin.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($userId)
    {
        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);
        $roles = $this->roleRepo->all();
        return view('user::admin.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(UpdateUserRequest $request, $userId)
    {

        $this->authorize('edit', User::class);
        $user = $this->userRepo->findById($userId);

        if ($request->hasFile('image')) {
            $request->request->add(['image_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($user->banner)
                $user->banner->delete();
        } else {
            $request->request->add(['image_id' => $user->image_id]);
        }

        $this->userRepo->update($userId, $request);
        newFeedback();
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user = $this->userRepo->findById($id);
        $user->delete();
        return AjaxResponses::successResponse();
    }

    public function manualVerify($userId)
    {
        $this->authorize('manualVerify', User::class);
        $user = $this->userRepo->findById($userId);
        $user->markEmailAsVerified();
        return AjaxResponses::SuccessResponse();
    }

    public function addRole(AddRoleRequest $request, User $user)
    {

        $this->authorize('addRole', User::class);
        $user->assignRole($request->role);
        newFeedback('موفقیت آمیز', "به کاربر {$user->name} نقش کاربری {$request->role} داده شد.", 'success');

        return back();
    }

    public function removeRole($userId, $role)
    {
        $this->authorize('removeRole', User::class);
        $user = $this->userRepo->findById($userId);
        $user->removeRole($role);
        return AjaxResponses::SuccessResponse();
    }
}
