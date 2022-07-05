<?php

namespace Modules\Course\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Common\Responses\AjaxResponses;
use Modules\Course\Entities\Course;
use Modules\User\Repositories\UserRepo;
use Modules\Category\Repositories\CatRepo;
use Modules\Course\Repositories\CourseRepo;
use Illuminate\Contracts\Support\Renderable;
use Modules\Media\Services\MediaFileService;
use Modules\Course\Http\Requests\CourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('manage',Course::class);
        $courses = $courseRepo->paginate();
        return view('course::index',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(UserRepo $userRepo,CatRepo $catRepo)
    {
//      $this->authorize('create', Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $catRepo->all();
        return view('course::create', compact('teachers', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CourseRequest $request,CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $course = $courseRepo->store($request);
        return redirect()->route('courses.index');

    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findById($id);
//        $this->authorize('edit', $course);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('course::edit', compact('course', 'teachers', 'categories'));

    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
//        $this->authorize('edit', $course);
        if ($request->hasFile('image')) {
            $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($course->banner)
                $course->banner->delete();
        } else {
            $request->request->add(['banner_id' => $course->banner_id]);

        }
        $courseRepo->update($id, $request);

        return redirect()->route('courses.index');
    }


    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
//        $this->authorize('delete', $course);
        if ($course->banner) {
            $course->banner->delete();
        }
        $course->delete();
        return AjaxResponses::successResponse();
    }

    public function accept($id, CourseRepo $courseRepo)
    {
//        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function reject($id, CourseRepo $courseRepo)
    {
//        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::FailedResponse();

    }

    public function lock($id, CourseRepo $courseRepo)
    {
//        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateStatus($id, Course::STATUS_LOCKED)) {
            return AjaxResponses::successResponse();
        }
        return AjaxResponses::FailedResponse();

    }

}
