<?php

namespace Modules\Slider\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Slider\Entities\Slide;
use App\Http\Controllers\Controller;

use Modules\Slider\Repositories\SlideRepo;
use Modules\Common\Responses\AjaxResponses;
use Modules\Media\Services\MediaFileService;
use Modules\Slider\Http\Requests\SlideRequest;


class SliderController extends Controller
{


    public function index(SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $slides = $repo->all();
        return view("slider::index", compact("slides"));
    }

    public function store(SlideRequest $request, SlideRepo $repo)
    {
        $this->authorize('manage', Slide::class);
        $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
        $repo->store($request);
        return redirect()->route('slides.index');
    }

    public function edit(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        return view("slider::edit", compact("slide"));

    }

    public function update(Slide $slide, SlideRepo $repo, SlideRequest $request)
    {
        $this->authorize('manage', Slide::class);
        if ($request->hasFile('image')) {
            $request->request->add(['media_id' => MediaFileService::publicUpload($request->file('image'))->id]);
            if ($slide->media)
                $slide->media->delete();
        } else {
            $request->request->add(['media_id' => $slide->media_id]);
        }
        $repo->update($slide->id, $request);
        return redirect()->route('slides.index');
    }

    public function destroy(Slide $slide)
    {
        $this->authorize('manage', Slide::class);
        if ($slide->media) {
            $slide->media->delete();
        }
        $slide->delete();

        return AjaxResponses::SuccessResponse();
    }








}
