<?php

namespace Modules\Course\Http\Requests;

use Illuminate\Validation\Rule;
use Modules\Course\Entities\Course;
use Modules\Course\Rules\ValidTeacher;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
       $rules =  [
        "title" => "required|min:3|max:190",
        "slug" => "required|min:3|max:190|unique:courses,slug",
        "priority" => "nullable|numeric",
        "price" => "required|numeric|min:0|max:10000000",
        "percent" => "required|numeric|min:0|max:100",
        "teacher_id" => ["required", "exists:users,id", new ValidTeacher()],
        "type" => ["required", Rule::in(Course::$types)],
        "status" => ["required", Rule::in(Course::$statuses)],
        "category_id" => "required|exists:categories,id",
        "image" => "required|file|image|mimes:jpg,png,jpeg|max:2048"
    ];

    if (request()->method === "PATCH"){
        $rules['image'] = "nullable|file|image|mimes:jpg,png,jpeg";
        $rules['slug'] = "required|min:3|max:190|unique:courses,slug,". request()->route('course');
    }
    return $rules;
}

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check() == true;
    }


    public function attributes()
    {
        return [
            "price" => "قیمت" ,
            "slug" => "عنوان انگلیسی",
            "priority" => "ردیف دوره",
            "percent" => "درصد مدرس",
            "teacher_id" => "مدرس",
            "category_id" => "دسته بندی",
            "status" => "وضیعت",
            "type" => "نوع",
            "body" => "توضیحات",
            "image" => "بنر دوره",

        ];

    }


    public function messages()
    {
        return [
//            "price.min" => trans("Courses::validation.price_min"),
//            "price.max" => trans("Courses::validation.price_max"),
//            "price.required" => trans("Courses::validation.price_required"),
        ];
    }
}
