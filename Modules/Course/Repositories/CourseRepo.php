<?php

namespace Modules\Course\Repositories;

use Str;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Lesson;
class CourseRepo
{


   public function paginate()
    {
        return Course::paginate();
    }

   public function findById($id)
    {
        return Course::findOrFail($id);
    }

    public function store($values)
    {
        return Course::create([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'status' => $values->status,
            'body' => $values->body,
            'confirmation_status' => Course::CONFIRMATION_STATUS_PENDING
        ]);
    }




    public function update($id, $values)
    {
        return Course::where('id',$id)->update([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => \Str::slug($values->slug),
            'priority' => $values->priority,
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'status' => $values->status,
            'body' => $values->body,

        ]);
    }

    public function updateConfirmationStatus($id,$status)
    {
        return Course::where('id',$id)->update(['confirmation_status' => $status]);
    }

    public function updateStatus($id, $status)
    {
        return Course::where('id',$id)->update(['status' => $status]);
    }

    public function getCoursesByTeacherId(?int $id)
    {
        return Course::where('teacher_id', $id)->get();
    }

    public function latestCourses()
    {
        return Course::where('confirmation_status',Course::CONFIRMATION_STATUS_ACCEPTED)->latest()->take(8)->get();
    }
    public function getDuration($id)
    {
        return $this->getLessonsQuery($id)->sum('time');
    }

    public function getLessons($id)
    {
        return $this->getLessonsQuery($id)->get();
    }


    private function getLessonsQuery($id)
    {
        return Lesson::where('course_id', $id)
            ->where('confirmation_status', Lesson::CONFIRMATION_STATUS_ACCEPTED);
    }
    public function getLessonsCount($id)
    {
        return $this->getLessonsQuery($id)->count();
    }

    public function hasStudent(Course $course, $student_id)
    {
        return $course->students->contains($student_id);
    }

    public function addStudentToCourse(Course $course, $studentId)
    {
        if (!$this->getCourseStudentById($course, $studentId)) {
            $course->students()->attach($studentId);
        }
    }

    public function getCourseStudentById(Course $course, $studentId)
    {
        return $course->students()->where("id", $studentId)->first();
    }

    public function getAll(string $status = null)
    {
        $query = Course::query();
        if ($status) $query->where("confirmation_status", $status);

        return $query
            ->latest()
            ->get();
    }



}


