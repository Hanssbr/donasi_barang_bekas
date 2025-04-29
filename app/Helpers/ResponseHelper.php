<?php

namespace App\Helpers;


class ResponseHelper {
    public static function jsonResponseMethod($status, $data = null,$token=null, $message = null, $errorCode = 200) {
        $res = ['status' => $status];

        if(!is_null($data)) {
            $res['data'] = $data;
        }
        if(!is_null('message')) {
            $res['message'] = $message;
        }
        if(!is_null($token)) {
            $res['token'] = $token;
        }

        return response()->json($res, $errorCode);
    }
}

