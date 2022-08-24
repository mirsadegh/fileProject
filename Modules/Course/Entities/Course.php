<?php

namespace Modules\Course\Entities;

use Modules\User\Entities\User;
use Modules\Media\Entities\Media;
use Modules\Payment\Entities\Payment;
use Illuminate\Database\Eloquent\Model;
use Modules\Category\Entities\Category;
use Modules\Discount\Entities\Discount;
use Modules\Course\Repositories\CourseRepo;
use Modules\Discount\Services\DiscountService;
use Modules\Discount\Repositories\DiscountRepo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE, self::TYPE_CASH];

    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';
    static $statuses = [self::STATUS_COMPLETED, self::STATUS_NOT_COMPLETED, self::STATUS_LOCKED];

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED , self::CONFIRMATION_STATUS_PENDING,self::CONFIRMATION_STATUS_REJECTED];


    protected static function newFactory()
    {
        return \Modules\Course\Database\factories\CourseFactory::new();
    }

    public function banner()
    {
        return $this->belongsTo(Media::class, 'banner_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }
    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class, "paymentable");
    }

    public function payment()
    {
        return $this->payments()->latest()->first();
    }

    public function discounts()
    {
        return $this->morphToMany(Discount::class, "discountable");
    }



    public function getDuration()
    {
        return (new CourseRepo())->getDuration($this->id);
    }

    public function formattedDuration()
    {
        $duration = $this->getDuration();
        $h = floor($duration / 60) < 10 ? '0' . floor($duration / 60) : floor($duration / 60);
        $m = ($duration % 60) < 10 ? '0' . ($duration % 60) : ($duration % 60);
        return $h . ':' . $m . ":00";
    }

    public function getFormattedPrice()
    {
        return number_format($this->price);
    }

    public function getDiscount()
    {
        $discountRepo = new DiscountRepo();
        $discount = $discountRepo->getCourseBiggerDiscount($this->id);
        $globalDiscount = $discountRepo->getGlobalBiggerDiscount();
        if ($discount == null && $globalDiscount == null) return null;
        if ($discount == null && $globalDiscount != null) return $globalDiscount;
        if ($discount != null && $globalDiscount == null) return $discount;
        if ($globalDiscount->percent > $discount->percent) return $globalDiscount;
        return $discount;

    }

    public function getDiscountPercent()
    {
        $discount = $this->getDiscount();
        if ($discount) return $discount->percent;

     }

    public function getDiscountAmount($percent = null)
    {
        if ($percent == null) {
            $discount = $this->getDiscount();
            $percent = $discount ? $discount->percent : 0;
        }
        return DiscountService::calculateDiscountAmount($this->price, $percent);

    }

    public function getFinalPrice($code = null, $withDiscounts = false)
    {
        $discount = $this->getDiscount();
        $amount = $this->price;

        $discounts = [];
        if ($discount) {
            $discounts [] = $discount;
            $amount = $this->price - $this->getDiscountAmount($discount->percent);
        }

        if ($code) {
            $repo = new DiscountRepo();
            $discountFromCode = $repo->getValidDiscountByCode($code, $this->id);
            if ($discountFromCode) {
                $discounts [] = $discountFromCode;
                $amount = $amount - DiscountService::calculateDiscountAmount($amount, $discountFromCode->percent);
            }
        }

        if ($withDiscounts)
        return [$amount, $discounts];

        return $amount;

    }

    public function getFormattedFinalPrice()
    {
        return number_format($this->getFinalPrice());
    }


    public function path()
    {
        return route('singleCourse', $this->id . '-' . $this->slug);
    }

    public function lessonsCount()
    {
        return (new CourseRepo())->getLessonsCount($this->id);
    }

    public function shortUrl()
    {
        return route('singleCourse', $this->id);
    }

    public function hasStudent($student_id)
    {
        return resolve(CourseRepo::class)->hasStudent($this, $student_id);
    }

    public function downloadLinks(): array
    {
        $links = [];
        foreach (resolve(CourseRepo::class)->getLessons($this->id) as $lesson) {
            $links[] = $lesson->downloadLink();
        }

        return $links;
    }


}
