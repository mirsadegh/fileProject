<?php

namespace Modules\Media\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Media\Entities\Media;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Media\Services\MediaFileService;

class MediaController extends Controller
{

    public function download(Media $media, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return MediaFileService::stream($media);
    }


}
