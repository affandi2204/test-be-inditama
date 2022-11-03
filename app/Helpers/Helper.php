<?php

use Illuminate\Support\Facades\Validator;

if(!function_exists('processRules')) {
    function processRules($request, $rules, $messages = [], $attributes = [])
    {
        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
