<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Swagger\Annotations as SWG;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     basePath="/",
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header"
 *     ),
 *     security={
 *         {"Bearer": {}}
 *     },
 *     tags={
 *         @SWG\Tag(
 *             name="OAUTH",
 *             description="授权认证相关"
 *         ),
 *         @SWG\Tag(
 *             name="Android",
 *             description="苟利国家生死以"
 *         ),
 *         @SWG\Tag(
 *             name="Magic",
 *             description="dfg@#$xfR#$%V"
 *         ),
 *     },
 *     @SWG\Info(
 *         version="1.0",
 *         title="CMS",
 *     ),
 *
 * )
 */



/**
 * Oauth 2.0 客户端凭证授权令牌
 *
 * @SWG\Post(
 *  tags={"OAUTH"},
 *  path="/oauth/token",
 *  summary="获取accessToken",
 *  @SWG\Parameter(
 *      in="body",
 *      name="body",
 *      required=true,
 *      @SWG\Schema(ref="#/definitions/OauthToken")
 *  ),
 *  @SWG\Response(
 *      response=401,
 *      description="",
 *  )
 * )
 */

class SwaggerController extends Controller
{
    public function doc(Request $request){

        $ip =  $request->getClientIp();

        if (in_array($ip, ['192.168.112.33','120.236.172.234','183.63.143.11', '127.0.0.1','120.236.172.235','183.63.143.131','210.21.107.11','120.236.172.232', '183.6.26.131'])) {
            $swagger = \Swagger\scan(realpath(__DIR__.'/../../'));
            // echo addslashes(json_encode($swagger, JSON_UNESCAPED_UNICODE )); exit();
            return response()->json($swagger);
        }else{

            return $ip;
        }
    }
}
