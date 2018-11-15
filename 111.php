<?php
/**
 * Created by PhpStorm.
 * User: chenzb
 * Date: 2018/11/1
 * Time: 下午4:03
 */


server {

    # 监听端口

    listen       8080;

    # 域名设定，可以有多个

    server_name  devadmin.dibook.cn;

    root /Users/chenzb/PhpstormProjects/dibook01/public;

    location / {

        # 定义路径下默认访问的文件名

        index index.php;
        if (!-e $request_filename){
                rewrite ^/(.*) /index.php last;
        }

        # 打开目录浏览功能，可以列出整个目录

        autoindex on;

    }

    #proxy the php scripts to php-fpm

    location ~ \.php$ {

        # fastcgi配置

        include /usr/local/etc/nginx/fastcgi.conf;

    # 指定是否传递4xx和5xx错误信息到客户端

    fastcgi_intercept_errors on;

    # 指定FastCGI服务器监听端口与地址，可以是本机或者其它

    fastcgi_pass   127.0.0.1:9000;

    }

}

