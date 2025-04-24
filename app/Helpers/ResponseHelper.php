<?php

namespace App\Helpers;


class ResponseHelper {
    public static function jsonResponseMethod($status, $data = null, $message = null, $errorCode = 200) {
        $res = ['status' => $status];

        if(!is_null($data)) {
            $res['data'] = $data;
        }
        if(!is_null('message')) {
            $res['message'] = $message;
        }

        return response()->json($res, $errorCode);
    }
}

