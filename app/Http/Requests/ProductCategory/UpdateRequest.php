<?php

namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules($id)
    {
        return [
            'name'    => ['required', 'string', 'max:255', 'unique:product_categories,name,'.$id],
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public static function getRules($id)
    {
        $these = new static;
        return $these->rules($id);
    }

    public static function getMessages()
    {
        $these = new static;
        return $these->messages();
    }
}
