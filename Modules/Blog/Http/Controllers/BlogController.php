<?php

namespace Modules\Blog\HTTP\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Repositories\BlogRepo;
use Modules\Category\Entities\Category;
use Modules\Category\Repositories\CatRepo;
use Modules\Blog\Http\Requests\BlogRequest;
use Modules\Common\Responses\AjaxResponses;
use Illuminate\Contracts\Support\Renderable;
use Modules\Media\Services\MediaFileService;

class BlogController extends Controller
{
    private $blogRepo;
    private $cateRepo;

    public function __construct(BlogRepo $blogRepo,CatRepo $catRepo)
    {
        $this->blogRepo = $blogRepo;
        $this->catRepo = $catRepo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $blogs =  $this->blogRepo->paginate();
        return view('blog::admin.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = $this->catRepo->all();
        return view('blog::admin.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(BlogRequest $request)
    {
        $inputs = $request->all();

        $realTimestampStart = substr($request->published_at, 0, 10);

        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);
        $extension = $request->image->getClientOriginalExtension();

        if (empty($extension)) {
            return redirect()->route('blogs.admin.create')->withErrors(['image' => 'پسوند عکس انتخاب شده معتبر نیست']);
        }
        $inputs["media_id"] = MediaFileService::publicUpload($request->file('image'))->id;
        $inputs["user_id"] = auth()->id();
        $this->blogRepo->store($inputs);
        return redirect()->route('blogs.admin.index')->with('swal-success', 'مقاله مورد نظر با موفقیت ایجاد گردید.');

    }



    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $blog = $this->blogRepo->findOrFail($id);
        $categories = $this->catRepo->all();
        return view('blog::admin.edit', compact('blog','categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(BlogRequest $request, $id)
    {

       $blog = $this->blogRepo->findOrFail($id);
       $inputs =  $request->all();
       $realTimestampStart = substr($request->published_at,0,10);
       $published =date("Y-m-d H:i:s",(int)$realTimestampStart);
       $now = Carbon::now()->toDateTimeString();
       $inputs["published_at"] = $published;

    //    if($published != $now){
    //       $inputs["published_at"] = $published;
    //    }else{
    //     dd($published);
    //     $inputs["published_at"] = $blog->published_at;
    //    };

       if ($request->hasFile('image')) {
        $extension = $request->image->getClientOriginalExtension();
        if (empty($extension)) {
            return redirect()->route('blogs.admin.edit', $id)->withErrors(['image' => 'پسوند عکس انتخاب شده معتبر نیست']);
        }

        $inputs["media_id"] = MediaFileService::publicUpload($request->file('image'))->id;
        // dd($inputs["media_id"]);
        if ($blog->media)
            $blog->media->delete();

    } else {
        $inputs['media_id'] = $blog->media_id;
    }

    $this->blogRepo->update($id,$inputs);

    return redirect()->route('blogs.admin.index')->with(['swal-success' => 'مقاله مورد نظر با موفقیت برروزرسانی گردید.']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
       $blog = $this->blogRepo->findOrFail($id);
       $blog->delete();
       return AjaxResponses::SuccessResponse();
    }
}
