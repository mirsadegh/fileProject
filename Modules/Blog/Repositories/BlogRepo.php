<?php

namespace Modules\Blog\Repositories;

use Modules\Blog\Entities\Blog;

class BlogRepo
{


    public function paginate()
    {
        return Blog::paginate();
    }



    public function store($values)
    {
         $blog = Blog::create([
            "title" => $values["title"],
            "category_id" => $values["category_id"],
            "status"  => $values["status"],
            "summary"  => $values["summary"],
            "body"  => $values["body"],
            "commentable" => $values["commentable"],
            "tags" => $values["tags"],
            "published_at" => $values["published_at"],
            "user_id" => $values["user_id"],
            "media_id" => $values["media_id"],
         ]);

         $slug = persianSlug($blog->title).'-'.$blog->id;
         $blog->update(['slug' => $slug]);
         return $blog;
    }

    public function update($id,$values)
    {
        $blog = Blog::where("id", $id)->update([
            "title" => $values["title"],
            "category_id" => $values["category_id"],
            "status"  => $values["status"],
            "summary"  => $values["summary"],
            "body"  => $values["body"],
            "commentable" => $values["commentable"],
            "tags" => $values["tags"],
            "published_at" => $values["published_at"],
            "media_id" => $values["media_id"],
         ]);

    }

    public function findOrFail($id)
    {
       return Blog::query()->findOrFail($id);
    }

    public function findBlogBySlug($slug)
    {
      return  Blog::query()->where("slug",$slug)->first();
    }

}
