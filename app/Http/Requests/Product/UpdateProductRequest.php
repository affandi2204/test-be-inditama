<?php

namespace App\Http\Requests\Product;
namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'product_category_id' => ['nullable'],
            'name'    => ['nullable', 'string', 'max:255'],
            'price'    => ['nullable'],
            'image'    => ['mimes:jpeg,jpg,png,gif|nullable|max:10000'],
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
