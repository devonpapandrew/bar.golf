<?php
/**
 * Created by PhpStorm.
 * User: devonpapandrew
 * Date: 11/23/16
 * Time: 10:03 PM
 */


class CannedResponse
{
    public static function unauthorized(){
        $response['body'] = self::error("Sorry, you are not authorized to perform this action.");
        $response['httpStatusCode'] = 403;
        return $response;
    }

    public static function unauthenticated(){
        $response['body'] = self::error("Sorry, you are not logged in. Please log in and try again.");
        $response['httpStatusCode'] = 403;
        return $response;
    }

    public static function unknownError($message = "Sorry, an unknown error has occured. Please try again, or contact support@siteliteapp.com if the problem persists." ){
        $response['body'] = self::error($message);
        $response['httpStatusCode'] = 200;
        return $response;
    }

    private static function error($message = null, $type = null, $code = null){
        $error = array();
        $error['success'] = 0;
        $error['error']['message'] = $message;
        $error['error']['type'] = $type;
        $error['error']['code'] = $code;

        return $error;
    }

    public static function success($data){
        $body = array();
        $body['data'] = $data;
        $body['success'] = 1;

        $response['body'] = $body;
        $response['httpStatusCode'] = 200;
        return $response;
    }

}