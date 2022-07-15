<?php

namespace Modules\Course\Http\Controllers;


use Modules\Course\Entities\Season;
use App\Http\Controllers\Controller;
use Modules\Common\Responses\AjaxResponses;
use Modules\Course\Repositories\CourseRepo;
use Modules\Course\Repositories\SeasonRepo;
use Modules\Course\Http\Requests\SeasonRequest;

class SeasonController extends Controller
{
    private $seasonRepo;
    public function __construct(SeasonRepo $seasonRepo)
    {
        $this->seasonRepo = $seasonRepo;
    }

    public function store($course, SeasonRequest $request, CourseRepo $courseRepo)
    {
        $this->authorize('createSeason', $courseRepo->findByid($course));
        $this->seasonRepo->store($course, $request);
        return back()->with('swal-success', 'سرفصل مورد نظر با موفقیت ایجاد گردید.');
    }

    public function edit($id)
    {
        $season = $this->seasonRepo->findByid($id);
        $this->authorize('edit', $season);
        return view('course::seasons.edit', compact('season'));
    }

    public function update($id, SeasonRequest $request)
    {
        $season = $this->seasonRepo->findByid($id);
        $this->authorize('edit', $season);
        $this->seasonRepo->update($id, $request);

        return redirect()->route('courses.details', $season->course_id)->with('swal-success', "سر فصل مورد نظر با موفقیت برروزرسانی گردید.");
    }

    public function accept($id)
    {
        $this->authorize('change_confirmation_status', Season::class);
        if ($this->seasonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function reject($id)
    {
        $this->authorize('change_confirmation_status', Season::class);
        if ($this->seasonRepo->updateConfirmationStatus($id, Season::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }

    public function lock($id)
    {
        $this->authorize('change_confirmation_status', Season::class);
        if ($this->seasonRepo->updateStatus($id, Season::STATUS_LOCKED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }
    public function unlock($id)
    {
        $this->authorize('change_confirmation_status', Season::class);
        if ($this->seasonRepo->updateStatus($id, Season::STATUS_OPENED)) {
            return AjaxResponses::SuccessResponse();
        }

        return AjaxResponses::FailedResponse();
    }
    public function destroy($id)
    {
        $season = $this->seasonRepo->findByid($id);
        $this->authorize('delete', $season);
        $season->delete();
        return AjaxResponses::SuccessResponse();
    }
}
