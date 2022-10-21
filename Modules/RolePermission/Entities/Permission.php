<?php

namespace Modules\RolePermission\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use \Spatie\Permission\Models\Permission as PermissionPackage;

class Permission extends PermissionPackage
{
    use HasFactory;

    protected $fillable = [];



    const PERMISSION_MANAGE_CATEGORIES = 'manage_categories';
    const PERMISSION_MANAGE_USERS = 'manage_users';
    const PERMISSION_MANAGE_COURSES = 'manage_courses';
    const PERMISSION_MANAGE_OWN_COURSES = 'manage_own_courses';
    const PERMISSION_MANAGE_ROLE_PERMISSIONS = 'manage_role_permissions';
    const PERMISSION_MANAGE_PAYMENTS = 'manage_payments';
    const PERMISSION_MANAGE_SETTLEMENTS = 'manage_settlements';
    const PERMISSION_MANAGE_DISCOUNT = 'manage_discounts';
    const PERMISSION_MANAGE_TICKETS = "manage_tickets";
    const PERMISSION_MANAGE_COMMENTS = "manage_comments";
    const PERMISSION_TEACH = 'teach';
    const PERMISSION_MANAGE_SLIDES = 'manage_slides';
    const PERMISSION_SUPER_ADMIN = 'super_admin';

    static $permissions = [
        self::PERMISSION_SUPER_ADMIN,
        self::PERMISSION_TEACH,
        self::PERMISSION_MANAGE_CATEGORIES,
        self::PERMISSION_MANAGE_ROLE_PERMISSIONS,
        self::PERMISSION_MANAGE_COURSES,
        self::PERMISSION_MANAGE_OWN_COURSES,
        self::PERMISSION_MANAGE_USERS,
        self::PERMISSION_MANAGE_PAYMENTS,
        self::PERMISSION_MANAGE_SETTLEMENTS,
        self::PERMISSION_MANAGE_DISCOUNT,
        self::PERMISSION_MANAGE_TICKETS,
        self::PERMISSION_MANAGE_COMMENTS,
        self::PERMISSION_MANAGE_SLIDES
    ];

}
