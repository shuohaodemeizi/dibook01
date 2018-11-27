<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS
    |--------------------------------------------------------------------------
    |
    | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
    | to accept any value.
    |
    */
   
    'supportsCredentials' => true,
    'allowedOrigins' => ['http://devhui.dibook.cn',
        'http://devhui.dibook.cn:8080',//弄错了
        'http://127.0.0.1:8080',
        'http://devwww.dibook.cn'],
    'allowedOriginsPatterns' => [],
    'allowedHeaders' => ['X-Requested-With', 'Content-Type', 'Origin', 'Cache-Control', 'Pragma', 'Authorization', 'Accept', 'Accept-Encoding'],
    'allowedMethods' => ['PUT', 'POST', 'GET','OPTIONS','DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,

];
