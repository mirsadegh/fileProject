<?php


namespace Models\Course\Http\Controllers;


use Illuminate\Http\Request;

use Modules\Course\Models\Lesson;
use Modules\Course\Entities\Course;
use App\Http\Controllers\Controller;
use Modules\Common\Responses\AjaxResponses;
use Modules\Course\Repositories\CourseRepo;
use Modules\Course\Repositories\LessonRepo;
use Modules\Course\Repositories\SeasonRepo;
use Modules\Media\Services\MediaFileService;
use Modules\Course\Http\Requests\LessonRequest;


class LessonController extends Controller
{
    /**
     * @var LessonRepo
     */
    private $lessonRepo;

    public function __construct(LessonRepo $lessonRepo)
    {
        $this->lessonRepo = $lessonRepo;
    }

    public function create($course, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($course);
        $this->authorize('createLesson', $course);
        $seasons = $seasonRepo->getCourseSeasons($course->id);
        return view('Courses::lessons.create', compact('seasons', 'course'));
    }

    public function store($course, LessonRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findByid($course);
        $this->authorize('createLesson', $course);
        $request->request->add(["media_id" => MediaFileService::privateUpload($request->file('lesson_file'))->id ]);
        $this->lessonRepo->store($course->id, $request);
        newFeedback();
        return redirect(route('courses.details', $course->id));
    }

    public function edit($courseId, $lessonId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $lesson = $this->lessonRepo->findByid($lessonId);
        $this->authorize('edit', $lesson);
        $seasons = $seasonRepo->getCourseSeasons($courseId);
        $course = $courseRepo->findByid($courseId);
        return view('Courses::lessons.edit', compact('lesson', 'seasons', 'course'));
    }

    public function update($courseId, $lessonId, LessonRequest $request)
    {
        $lesson = $this->lessonRepo->findByid($lessonId);
        $this->authorize('edit', $lesson);
        if ($request->hasFile('lesson_file')) {

            if ($lesson->media)
                $lesson->media->delete();

            $request->request->add(["media_id" => MediaFileService::privateUpload($request->file('lesson_file'))->id ]);
        }else{
            $request->request->add(['media_id'=> $lesson->media_id]);
        }
        $this->lessonRepo->update($lessonId, $courseId, $request);
        newFeedback();
        return redirect(route('courses.details', $courseId));
    }
    public function accept($id)
    {
        $this->authorize('manage', Course::class);
        $this->lessonRepo->updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        return AjaxResponses::SuccessResponse();
    }

    public function acceptAll($courseId)
    {
        $this->authorize('manage', Course::class);
        $this->lessonRepo->acceptAll($courseId);
        newFeedback();
        return back();
    }

    public function acceptMultiple(Request $request)
    {
        $this->authorize('manage', Course::class);
        $ids = explode(',', $request->ids);
        $this->lessonRepo->updateConfirmationStatus($ids, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        newFeedback();
        return back();
    }

    public function rejectMultiple(Request $request)
    {
        $this->authorize('manage', Course::class);
        $ids = explode(',', $request->ids);
        $this->lessonRepo->updateConfirmationStatus($ids, Lesson::CONFIRMATION_STATUS_REJECTED );
        newFeedback();
        return back();
    }

    public function reject($id)
    {
        $this->authorize('manage', Course::class);
        $this->lessonRepo->updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_REJECTED);
        return AjaxResponses::SuccessResponse();
    }

    public function lock($id)
    {
        $this->authorize('manage', Course::class);
        if ($this->lessonRepo->updateStatus($id, Lesson::STATUS_LOCKED)){
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }
    public function unlock($id)
    {
        $this->authorize('manage', Course::class);
        if ($this->lessonRepo->updateStatus($id, Lesson::STATUS_OPENED)){
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function destroy($courseId, $lessonId)
    {
        $lesson = $this->lessonRepo->findByid($lessonId);
        $this->authorize('delete', $lesson);
        if ($lesson->media){
            $lesson->media->delete();
        }
        $lesson->delete();
        return AjaxResponses::SuccessResponse();
    }

    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $lesson = $this->lessonRepo->findByid($id);
            $this->authorize('delete', $lesson);
            if ($lesson->media){
                $lesson->media->delete();
            }
            $lesson->delete();
        }
        newFeedback();
        return back();
    }
}
