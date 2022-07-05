<?php

namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as RolePackage;

class Role extends RolePackage
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\RolePermission\Database\factories\RoleFactory::new();
    }

    const ROLE_TEACHER = 'teacher';
    const ROLE_SUPER_ADMIN = 'super admin';
    const ROLE_STUDENT = 'student';

    static $roles = [
        self::ROLE_TEACHER => [
            Permission::PERMISSION_TEACH,
        ],
        self::ROLE_SUPER_ADMIN => [
            Permission::PERMISSION_SUPER_ADMIN
        ],
        self::ROLE_STUDENT => [

        ]
    ];
}
