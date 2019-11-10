<?php

namespace App\Tools;

use Symfony\Component\HttpFoundation\Response;

class ResponseWrapper
{
    const RESPONSE_DESCRIPTION = 'response_description';

    public static function successMessage($responseMessage, $responseCode = Response::HTTP_OK, $headers = [], $options = 0)
    {
        return response()->json(
            [
                ResponseWrapper::RESPONSE_DESCRIPTION => $responseMessage
            ],
            $responseCode,
            $headers,
            $options
        );
    }

    public static function successObject($responseObject, $responseCode = Response::HTTP_OK, $headers = [], $options = 0)
    {
        return response()->json($responseObject, $responseCode, $headers, $options);
    }
}
