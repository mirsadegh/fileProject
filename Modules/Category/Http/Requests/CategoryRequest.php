<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'      => 'required|max:190|unique:categories,title',
            'slug'       => 'required|max:190|unique:categories,title',
            'parent_id'  => 'nullable|exists:categories,id',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check()  == true;
    }

    public function attributes()
    {
        return [
            "parent_id" => "دسته والد",
            "slug" => "اسلاگ"
        ];
    }
}
