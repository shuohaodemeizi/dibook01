<?php
/**
 * Created by PhpStorm.
 * User: chenzb
 * Date: 2018/10/23
 * Time: 下午10:32
 */

require_once(__DIR__ . '/../vendor/autoload.php');

use Beanbun\Beanbun;
$beanbun = new Beanbun;
$beanbun->seed = [
    'https://dyz91.com/xjinfo.php?id=5031',
];
$beanbun->afterDownloadPage = function($beanbun) {
    file_put_contents(__DIR__ . '/' . md5($beanbun->url), $beanbun->page);
};
$beanbun->start();




/*
 *   //div[@class='hd-lf']/h1     标题
 *  //div[@class='hd-lf']/p/em    时间
 *  内容 http://devwww.dibook.cn:8080/12.html
 *  //div[@class='info-bd']/p     内容
 *                                联系电话
 *  //div[@class='info-bd']/p/span/img/@src 图片
 */