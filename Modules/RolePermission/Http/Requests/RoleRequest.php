<?php

namespace Modules\RolePermission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "name" => "required|min:3|unique:roles,name",
            "permissions" => "required|array|min:1"
          ];
        }elseif($this->isMethod('patch')){
            return [
                "id" => "required|exists:roles,id",
                "name" => "required|min:3|unique:roles,name," . request()->id,
                "permissions" => "required|array|min:1"
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
