<?php

namespace Modules\Blog\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class blogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('post')) {

            return [
                'title' => 'required|max:120|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'summary' => 'required|max:400|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.،,><\/;\n\r& ]+$/u',
                'category_id' => 'required|min:1|max:1000000|regex:/^[0-9]+$/u|exists:categories,id',
                'image' => 'required|image|mimes:png,jpg,jpeg,gif',
                'status' => 'required|numeric|in:0,1',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'body' => 'required|max:6000|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.،,><\/;\n\r& ]+$/u',
                'published_at' => 'required|numeric'
            ];
        }else{
            //  dd(request('body'));
            return [
                'title' => 'required|max:120|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'summary' => 'required|max:400|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.،,><\/;\n\r& ]+$/u',
                'category_id' => 'required|min:1|max:1000000|regex:/^[0-9]+$/u|exists:categories,id',
                'image' => 'image|mimes:png,jpg,jpeg,gif',
                'status' => 'required|numeric|in:0,1',
                'tags' => 'required|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'body' => 'required|max:6000|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.،,><\/;\n\r& ]+$/u',
                'published_at' => 'numeric'
            ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
