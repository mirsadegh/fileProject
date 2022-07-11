<?php

namespace Modules\User\Policies;

use Modules\RolePermission\Entities\Permission;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index($user)
    {
       if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users))
       {
          return true;
       }
    }
    public function edit($user)
    {
       if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users))
       {
          return true;
       }
    }

    public function addRole($user)
    {
       if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users))
       {
          return true;
       }
    }
    public function manualVerify($user)
    {
       if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users))
       {
          return true;
       }
    }
    public function removeRole($user)
    {
       if($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users))
       {
          return true;
       }
    }
}
