<?php

namespace App\Helpers;

class Helper
{
    public function array2xml($array, $xml = false)
    {
        if($xml === false){
            $xml = new \SimpleXMLElement('<root/>');
        }

        foreach($array as $key => $value){
            if(is_array($value)){
                if (is_numeric($key)) $key = 'item';
                $this->array2xml($value, $xml->addChild($key));
            } else {
                if ($key == 'introtext' or $key == 'fulltext') {
                    $value = '<![CDATA['. $value .']]>';
                    $xml->addChild($key, $value);
                } else {
                    $xml->addAttribute($key, $value);
                }
            }
        }

        return $xml->asXML();
    }

    /**
     * @param $url 请求网址
     * @param bool $params 请求参数
     * @param int $ispost 请求方式
     * @param int $https https协议
     * @return bool|mixed
     */
    public static function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }

    //格式化时间：input：时间戳 output：1小时前
    public static function format_date($timestamp){

        $t=time()-strtotime($timestamp);
        if($t>0){$ba = '前';}else{$ba = '后';}

        $f=array(
            //'31536000'=>'年',
            //'2592000'=>'个月',
            '604800'=>'星期',
            '86400'=>'天',
            '3600'=>'小时',
            '60'=>'分钟',
            '1'=>'秒'
        );

        foreach ($f as $k=>$v) {
            if (0 !=$c=floor(abs($t)/(int)$k)) {
                return $c.$v.$ba;
            }
        }
    }

    /**
     * 导出excel(csv)
     * @data 导出数据
     * @headlist 第一行,列名  array（name=>'姓名'，'sex'=>'性别'）
     * @fileName 输出Excel文件名
     */
    public static function csv_export($data = array(), $headlist = array(), $fileName) {

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$fileName.'.csv"');
        header('Cache-Control: max-age=0');

        //打开PHP文件句柄,php://output 表示直接输出到浏览器
        $fp = fopen('php://output', 'a');

        //输出Excel列名信息
        foreach ($headlist as $key => $value) {
            //CSV的Excel支持GBK编码，一定要转换，否则乱码
            $row0[] = $value;//iconv('utf-8', 'gbk', $value);
        }

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $row0);

        //计数器
        $num = 0;

        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;

        //逐行取出数据，不浪费内存
        $count = count($data);
        for ($i = 0; $i < $count; $i++) {

            $num++;

            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }

            $row = $data[$i];
//            foreach ($row as $key => $value) {
//                $row[$key] = iconv('utf-8', 'gbk', $value);
//            }
            $row111 = array();
            foreach ($headlist as $key=>$value) {
                if (is_object($row)) {
                    if (isset($row->$key)) {
                        $row111[] = $row->$key;//iconv('utf-8', 'gbk', $row->$key);
                    }
                }else{
                    if (isset($row[$key])) {
                        $row111[] = is_null($row[$key])?'':$row[$key];//iconv('utf-8', 'gbk', $row[$key]);
                    }
                }
            }

            fputcsv($fp, $row111);
        }
    }

    public static function csv_generation($data = array(), $headlist = array(), $fileName, $path='storage/')
    {
        if (!is_dir($path)) mkdir($path);
        $fp = fopen($path.$fileName.'.csv', 'a');
        //输出Excel列名信息
        foreach ($headlist as $key => $value) {
            //CSV的Excel支持GBK编码，一定要转换，否则乱码
            $row0[] = $value;//iconv('utf-8', 'gbk', $value);
        }

        //将数据通过fputcsv写到文件句柄
        fputcsv($fp, $row0);
        //计数器
        $num = 0;
        $limit = 10000;

        $count = count($data);
        for ($i = 0; $i < $count; $i++) {

            $num++;

            //刷新一下输出buffer，防止由于数据过多造成问题
            if ($limit == $num) {
                ob_flush();
                flush();
                $num = 0;
            }

            $row = $data[$i];
//            foreach ($row as $key => $value) {
//                $row[$key] = iconv('utf-8', 'gbk', $value);
//            }
            $row111 = array();
            foreach ($headlist as $key=>$value) {
                if (is_object($row)) {
                    if (isset($row->$key)) {
                        $row111[] = $row->$key;//iconv('utf-8', 'gbk', $row->$key);
                    }
                }else{
                    if (isset($row[$key])) {
                        $row111[] = is_null($row[$key])?'':$row[$key];//iconv('utf-8', 'gbk', $row[$key]);
                    }
                }
            }

            fputcsv($fp, $row111);
        }
    }

    /**
     * @param $data
     * $data['tpl_id']=必填
     * $data['tpl_value']="code=xxxx&code2=xxxx"，按須
     * $data['apikey']=apikey，系統填
     * $data['mobile']=12312312311，必填
     * @return bool|string
     */
    public function yunpian_tpl_send($data){
        if(!isset($data['apikey'])){
            $data['apikey'] = "6de1729c9eeff2a0626d86e76af7e98f";
        }
        if (empty($data['tpl_id'])) {
            //echo 'tpl_id is null';
            return ;
        }

        $ch = curl_init();

        /* 设置验证方式 */
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8',
            'Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        /* 设置返回结果为流 */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        /* 设置超时时间*/
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        /* 设置通信方式 */
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt ($ch, CURLOPT_URL,
            'https://sms.yunpian.com/v2/sms/tpl_single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        $error = curl_error($ch);

        return $result;
    }

    /** 年份的数组s
    */
    public static function getBetweenArray($start,$end)
    {
        $arr = array();
        for ($x=$start; $x<=$end; $x++) {
            $arr[] = $x;
        }
        return $arr;
    }

    /**
     * csv 写文件
     *
     * @param string $var
     * @return void
     */
    public function csv_generation_file($var)
    {

    }

}
