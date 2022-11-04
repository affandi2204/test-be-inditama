<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

if(!function_exists('processRules')) {
    function processRules($request, $rules, $messages = [], $attributes = [])
    {
        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}

if(!function_exists('storageUrl')) {
    function storageUrl($image)
    {
        return $image ? url('/').Storage::url($image) : null;;
    }
}
