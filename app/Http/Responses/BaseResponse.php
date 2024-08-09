<?php

namespace App\Http\Responses;


class BaseResponse
{
    /**
     * Base Response used by endpoints
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public static function successResponse($message)
    {
        $response = [
            'responseCode' => '200',
            'responseMessage' => 'Success ' . $message,
        ];
        return response()->json($response);
    }

    public static function errorResponse($message)
    {
        $response = [
            'responseCode' => '500',
            'responseMessage' => $message,
        ];
        return response()->json($response);
    }

    public static function successResponseData($message, $data)
    {
        $response = [
            'responseCode' => '200',
            'responseMessage' => 'Success ' . $message,
            'data' => $data
        ];
        return response()->json($response);
    }
}
