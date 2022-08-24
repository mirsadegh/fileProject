<?php

namespace Modules\Discount\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Course\Entities\Course;
use App\Http\Controllers\Controller;
use Modules\Discount\Entities\Discount;
use Modules\Common\Responses\AjaxResponses;
use Modules\Course\Repositories\CourseRepo;
use Illuminate\Contracts\Support\Renderable;
use Modules\Discount\Services\DiscountService;
use Modules\Discount\Repositories\DiscountRepo;
use Modules\Discount\Http\Requests\DiscountRequest;


class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CourseRepo $courseRepo, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $discounts = $repo->paginateAll();
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view("discount::index", compact("courses", "discounts"));
    }

    public function store(DiscountRequest $request, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $repo->store($request->all());
        newFeedback();
        return back();
    }

    public function edit(Discount $discount, CourseRepo $courseRepo)
    {
        $this->authorize("manage", Discount::class);
        $courses = $courseRepo->getAll(Course::CONFIRMATION_STATUS_ACCEPTED);
        return view("discount::edit", compact("discount", "courses"));
    }

    public function update(Discount $discount, DiscountRequest $request, DiscountRepo $repo)
    {
        $this->authorize("manage", Discount::class);
        $repo->update($discount->id, $request->all());
        newFeedback();
        return redirect()->route("discounts.index");

    }

    public function destroy(Discount $discount)
    {
        $this->authorize("manage", Discount::class);
        $discount->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function check($code, Course $course, DiscountRepo $repo)
    {

        $discount = $repo->getValidDiscountByCode($code, $course->id);
        if ($discount){
            $discountAmount = DiscountService::calculateDiscountAmount($course->getFinalPrice(), $discount->percent);
            $discountPercent = $discount->percent;
            $response = [
                "status" => "valid",
                "payableAmount" => $course->getFinalPrice() - $discountAmount,
                "discountAmount" => $discountAmount,
                "discountPercent" => $discountPercent
            ];
            return response()->json($response);
        }

        return \response()->json([
            "status" => "invalid"
        ])->setStatusCode(422);
    }






}
