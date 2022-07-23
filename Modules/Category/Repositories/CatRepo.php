<?php

namespace Modules\Category\Repositories;

use Modules\Category\Entities\Category;


class CatRepo
{


     public function all()
     {
        return Category::all();
     }

     public function findById($id)
     {
       return Category::findOrFail($id);
     }

     public function create($values)
     {
        return Category::create([
              "title" => $values["title"],
              "slug" => $values["slug"],
              "parent_id" => $values["parent_id"],
        ]);
     }

     public function update($values,$id)
     {
         $category = $this->findById($id);
         return  $category->update($values);

     }

     public function delete($id)
     {
        Category::where('id',$id)->delete();
     }

     public function categoriesEdit($id)
     {
        return Category::where('id','!=',$id)->get();
     }

     public function tree()
     {
        return Category::where('parent_id',null)->with('subCategories')->get();
     }



}
