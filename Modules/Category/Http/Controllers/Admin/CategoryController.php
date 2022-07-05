<?php

namespace Modules\Category\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\Category\Repositories\CatRepo;
use Illuminate\Contracts\Support\Renderable;
use Modules\Category\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public $catRepo ;
    public function __construct(CatRepo $catRepo)
    {
        return  $this->catRepo = $catRepo;
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $categories = $this->catRepo->all();
        return view('category::index',compact('categories'));
    }



    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CategoryRequest $request)
    {
         $this->catRepo->create($request->all());
         //alert ok
         return back();

    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $category = $this->catRepo->findById($id);
        $categories = $this->catRepo->categoriesEdit($id);
        return view('category::edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(CategoryRequest $request, $id)
    {
         $category =  $this->catRepo->update($request->all(),$id);

         return redirect()->route('admin.categories.index')->with('swal-success','دسته بندی مورد نظر با موفقیت برروزرسانی گردید.');

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
       $this->catRepo->delete($id);
       return response()->json(['message' => 'عملیات با موفقیت انجام شد.'],Response::HTTP_OK);

    }
}
