<?php

namespace Modules\User\Entities;

use Laravel\Sanctum\HasApiTokens;
use Modules\Media\Entities\Media;
use Modules\Course\Entities\Course;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Modules\RolePermission\Entities\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;


    protected $fillable = [
    'name',
    'email',
    'mobile',
    'status',
    'user_type',
    'activation',
    'profile_photo_path',
    'password',
    'email_verified_at',
    'mobile_verified_at',
];

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\UserFactory::new();
    }

        /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    const STATUS_ACTIVE = "active";
    const STATUS_INACTIVE = "inactive";
    const STATUS_BAN = "ban";
    public static $statuses = [
        self::STATUS_ACTIVE,
        self::STATUS_INACTIVE,
        self::STATUS_BAN
    ];

    public static $defaultUsers = [
        [
            'email' => 'admin@site.com',
            'password' => 'admin',
            'name' => 'Admin',
            'role' => Role::ROLE_SUPER_ADMIN
        ],
        [
            'email' => 'teacher@site.com',
            'password' => 'teacher',
            'name' => 'Teacher',
            'role' => Role::ROLE_TEACHER
        ],
        [
            'email' => 'student@site.com',
            'password' => 'student',
            'name' => 'Student',
            'role' => Role::ROLE_STUDENT
        ]
    ];


    public function image()
    {
        return $this->belongsTo(Media::class,'image_id');
    }

    public function getThumbAttribute()
    {
        if ($this->image)
            return '/storage/' . $this->image->files[300];

        return '/panel/img/profile.jpg';
    }

    public function courses()
    {
        return $this->hasMany(Course::class,'teacher_id');
    }

    public function purchases()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }

    public function seasons()
    {
       return $this->hasMany(Season::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function profilePath()
    {
        // return null;
        return $this->username ? route('admin.viewProfile', $this->username) : route('admin.viewProfile', 'username');
    }

    public function studentsCount()
    {
        return \DB::table("courses")
            ->select("course_id")->where("teacher_id", $this->id)
            ->join("course_user", "courses.id", "=", "course_user.course_id")->count();
    }


}
