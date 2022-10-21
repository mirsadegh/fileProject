<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use Modules\Category\Repositories\CatRepo;
use Modules\Blog\Http\Requests\BlogRequest;
use Illuminate\Contracts\Support\Renderable;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('blog::admin.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(CatRepo $catRepo)
    {
        $categories = $catRepo->all();
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
        dd($inputs['published_at']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('blog::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('blog::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
