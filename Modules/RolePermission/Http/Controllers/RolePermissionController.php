<?php

namespace Modules\RolePermission\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Contracts\Support\Renderable;
use Modules\RolePermission\Repositories\RoleRepo;
use Modules\RolePermission\Http\Requests\RoleRequest;
use Modules\RolePermission\Repositories\PermissionRepo;

class RolePermissionController extends Controller
{
    private $roleRepo;
    private $permissionRepo;
    public function __construct(RoleRepo $roleRepo,PermissionRepo $permissionRepo)
    {
       $this->roleRepo = $roleRepo;
       $this->permissionRepo = $permissionRepo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $roles = $this->roleRepo->all();
        $permissions = $this->permissionRepo->all();
        return view('rolepermission::index',compact('roles','permissions'));
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(RoleRequest $request)
    {
          $this->roleRepo->create($request);
          return redirect()->route('role-permissions.index')->with('swal-success','نقش کاربری شما با موفقیت ایجاد گردید.');
    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $role = $this->roleRepo->findById($id);
        $permissions = $this->permissionRepo->all();
        return view('rolepermission::edit', compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(RoleRequest $request, $id)
    {
       $role = $this->roleRepo->update($id,$request);
       return redirect()->route('role-permissions.index')->with('swal-success','نقش کاربری شما با موفقیت برروزرسانی گردید.');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $this->roleRepo->delete($id);
        return response()->json(['message'=>  'عملیات با موفقیت انجام شد.'],Response::HTTP_OK);
    }
}
