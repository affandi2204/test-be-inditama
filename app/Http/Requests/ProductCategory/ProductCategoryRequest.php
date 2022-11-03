<?php

namespace App\Http\Requests\ProductCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ProductCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'    => ['required', 'string', 'max:255', 'unique:product_categories,name'],
        ];
    }

    public function messages()
    {
        return [
            //
        ];
    }

    public static function getRules()
    {
        $these = new static;
        return $these->rules();
    }

    public static function getMessages()
    {
        $these = new static;
        return $these->messages();
    }
}
