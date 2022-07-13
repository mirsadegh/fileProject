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


    public function create(UserRepo $userRepo,CatRepo $catRepo)
    {
                //      $this->authorize('create', Course::class);
      $teachers = $userRepo->getTeachers();
      $categories = $catRepo->all();
      return view('course::create', compact('teachers', 'categories'));
  }


  public function store(CourseRequest $request,CourseRepo $courseRepo)
  {
      $extension = $request->image->getClientOriginalExtension();
      if(empty($extension)){
          return redirect()->route('courses.create')->withErrors(['image' => 'پسوند عکس انتخاب شده معتبر نیست']);
      }

      if ($request->type == 'free' && $request->price != 0) {
          return back()->withErrors(['type' => 'برای دوره رایگان قیمت باید صفر باشد.']);
      }

      if ($request->type == 'free' && $request->percent != 0) {
          return back()->withErrors(['type' => 'برای دوره رایگان درصد مدرس باید صفر باشد.']);
      }


      $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);

      $course = $courseRepo->store($request);
      return redirect()->route('courses.index')->with('swal-success','دوره مورد نظر با موفقیت ایجاد گردید.');

  }



  public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CatRepo $categoryRepo)
  {
//        $this->authorize('edit', $course);
    $course = $courseRepo->findById($id);
    $teachers = $userRepo->getTeachers();
    $categories = $categoryRepo->all();

    return view('course::edit', compact('course', 'teachers', 'categories'));

}



public function update($id, CourseRequest $request, CourseRepo $courseRepo)
{
    $course = $courseRepo->findById($id);

    if ($request->type == 'free' && $request->price != 0) {
      return back()->withErrors(['type' => 'برای دوره رایگان قیمت باید صفر باشد.']);
  }

  if ($request->type == 'free' && $request->percent != 0) {
      return back()->withErrors(['type' => 'برای دوره رایگان درصد مدرس باید صفر باشد.']);
  }

//        $this->authorize('edit', $course);
if ($request->hasFile('image')) {
   $extension = $request->image->getClientOriginalExtension();
   if(empty($extension)){
     return redirect()->route('courses.edit',$course->id)->withErrors(['image' => 'پسوند عکس انتخاب شده معتبر نیست']);
 }

 $request->request->add(['banner_id' => MediaFileService::publicUpload($request->file('image'))->id]);
 if ($course->banner)
    $course->banner->delete();

}
else {
    $request->request->add(['banner_id' => $course->banner_id]);
}

$courseRepo->update($id, $request);

return redirect()->route('courses.index')->with(['swal-success' => 'دوره مورد نظر با موفقیت برروزرسانی گردید.']);
}



public function destroy($id, CourseRepo $courseRepo)
{
    $course = $courseRepo->findById($id);
//        $this->authorize('delete', $course);
    if ($course->banner) {
        $course->banner->delete();
    }
    $course->delete();
    return AjaxResponses::SuccessResponse();
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

public function completed($id , CourseRepo $courseRepo)
{

    if($courseRepo->updateStatus($id, Course::STATUS_COMPLETED)){
        return AjaxResponses::successResponse();
    }
    return AjaxResponses::FailedResponse();
}

}
