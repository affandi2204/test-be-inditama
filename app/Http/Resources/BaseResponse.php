<?php

namespace App\Http\Resources;

use App\Http\Controllers\Controller;

class BaseResponse extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'success'       => true,
            'data'          => $result,
            'message'       => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @return  \Illuminate\Http\Response
     */
    public function sendError($error, $code = 404)
    {
        $response = [
            'data' => null,
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
