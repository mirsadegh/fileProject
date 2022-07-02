<?php

namespace Modules\RolePermission\Repositories;

use Spatie\Permission\Models\Role;

class RoleRepo
{


    public function all()
    {
        return Role::all();
    }

    public function create($request)
    {
        return Role::create(['name' => $request->name])->syncPermissions($request->permissions);
    }

    public function update($id,$request)
    {
        $role = $this->findById($id);
        return $role->syncPermissions($request->permissions)->update(['name'=>$request->name]);
    }

    public function delete($id)
    {
        Role::where('id',$id)->delete();
    }


    public function findById($id)
    {
        return Role::findOrFail($id);
    }


}