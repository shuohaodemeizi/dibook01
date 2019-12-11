<?php

namespace App\Helpers;

class RedIcon
{
    // app 个人中心获取红点（和设置红点）
    public function get($user_id)
    {
        $redis = app('redis')->connection('mydefault');
        $sys_messages=$redis->getbit('binary_sys_messages',$user_id);//系统消息
        $chat_messages = $redis->getbit('binary_chat_messages',$user_id);//私信
        $comment = $redis->getbit('binary_be_comment',$user_id);//被评论
        $home = $sys_messages+$chat_messages+$comment;
        $messages = $sys_messages+$chat_messages;

        return ['sys_messages'=>boolval($sys_messages),
            'chat_messages'=>boolval($chat_messages),
            'be_comment'=>boolval($comment),
            'messages'=>boolval($messages),
            'home'=>boolval($home),
        ];
    }

    // app 调用情况：某用被评论时，后台给某个用户发送消息时，app端评论及其他被举报时（系统消息）
    public function set($redis_key, $user_id, $bool=1)
    {
        $allow_key = ["binary_sys_messages","binary_chat_messages","binary_be_comment"];
        if (!in_array($redis_key, $allow_key)) {
            return '-1';
        }
        $redis = app('redis')->connection('mydefault');
        $val=$redis->setbit($redis_key, $user_id, $bool);
        return $val;
    }

    // 统计：今天用户签到数，任务完成数（阅读，评论，分享）
    public function getCnt($redis_key)
    {
        //bitCount a 0 1 表示统计第0个字节到第1个字节中，值为1的位的数量
        //用户ID encode成16进制后hash，再转成int
        //命令 BITOP operation destkey key [key ...]
        //BITOP 命令支持 AND 、 OR 、 NOT 、 XOR 这四种操作中的任意一种参数
        //对一个或多个保存二进制位的字符串 key 进行位元操作，并将结果保存到 destkey 上
        //例如：
        // redis->bitOp('AND', 'stat', 'stat_2017-01-10', 'stat_2017-01-11', 'stat_2017-01-12') . PHP_EOL; 
        //总活跃用户：6 
        ////echo "总活跃用户：" . $redis->bitCount('stat') . PHP_EOL;  
    }
}

