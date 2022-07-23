<?php

namespace Modules\Front\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Course\Repositories\CourseRepo;
use Modules\Course\Repositories\LessonRepo;
use Illuminate\Contracts\Support\Renderable;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('front::index');

    }

    public function singleCourse($slug,CourseRepo $courseRepo,LessonRepo $lessonRepo)
    {
          $courseId = $this->extractId($slug, 'c');
          $course = $courseRepo->findByid($courseId);
          $lessons = $lessonRepo->getAcceptedLessons($courseId);
          if (request()->lesson) {
            $lesson = $lessonRepo->getLesson($courseId, $this->extractId(request()->lesson, 'l'));
        } else {
            $lesson = $lessonRepo->getFirstLesson($courseId);
        }
          return view('front::singleCourse', compact('course','lessons','lesson'));
    }

    public function extractId($slug, $key)
    {
        return Str::before(Str::after($slug, $key .'-'), '-');
    }






}
