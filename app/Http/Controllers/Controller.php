<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function json_output($code, $msg, $data = NULL, $format = 'json')
    {
        if (is_null($data)) {
            return response()->json(['code' => $code, 'msg' => $msg]);
        }
        return response()->json(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }

    protected function mobile_response($code, $data = NULL, $msg = Null, $format = 'json')
    {
        if ($format == 'xml') {
            $helper = new Handler;
            $xml = $helper->array2xml($data, false);
            return response($xml)->withHeaders([
                "Content-Type" => 'text/xml'
            ]);
        }

        if (is_null($msg)){
            $msg = config('statusCode.' . $code);
        }
        if (is_null($data)) {
            return response()->json(['code' => $code, 'msg' => $msg]);
        }
        if (empty($data)) {
            $data = new \stdClass();
        }
        return response()->json(['code' => $code, 'data' => $data, 'msg' => $msg]);
    }
}
