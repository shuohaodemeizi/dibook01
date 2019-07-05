<?php

namespace App\Console\Commands;

use App\Models\Garbages;
use App\Models\ProductItems;
use App\Models\Topics;
use App\Models\TsPoetryAuthor;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use JonnyW\PhantomJs\Client;

class ts300 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ts300';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '唐诗300';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public static $poetryDataPath;
    public static $poemsDataPath;
    public static $lunyuDataPath;
    public static $shijingDataPath;
    public static $db;

    public function handle()
    {
        /*
         * 感谢以下项目的贡献者：

中华古诗词数据库
https://github.com/chinese-poetry/chinese-poetry

A simple, fast, and fun package for building command line apps in Go
https://github.com/urfave/cli

Tiny cross-platform webview library for C/C++/Golang
https://github.com/zserge/webview

A Vue.js 2.0 UI Toolkit for Web
https://github.com/ElemeFE/element

ImageMagick 7
https://github.com/ImageMagick/ImageMagick

Set the desktop wallpaper on Windows
https://github.com/sindresorhus/win-wallpaper

        mysql：https://github.com/KomaBeyond/chinese-poetry-mysql
         * */

        // https://github.com/shuohaodemeizi/chinese-poetry.git
        //https://shici.store/huajianji/www/poetrys/6825881154683802894.html

        // 把数据更新到mysql ：https://github.com/KomaBeyond/chinese-poetry-mysql#表结构说明

        set_time_limit(0);
        $poetryBasePath  = storage_path()."/chinese-poetry";
        $this::$poetryDataPath  = $poetryBasePath."/json";
        $this::$poemsDataPath   = $poetryBasePath."/ci";
        $this::$lunyuDataPath   = $poetryBasePath."/lunyu";
        $this::$shijingDataPath = $poetryBasePath."/shijing";
        $host = env('DB_HOST');
        $port = 3306;
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');
        $poetryDb = "ts300";
        $db = $this::$db = mysqli_connect($host, $username, $password, $poetryDb, $port);
        if (mysqli_connect_error()) {
            die("Connect Error: ".mysqli_connect_errno());
        }
        if (!mysqli_set_charset($db, "utf8")) {
            die("Error loading character set utf8: ".mysqli_error($db));
        }
        $this->mkSQL();

    }

    //============================= 执行函数区
    function mkSQL() {

        //生成唐宋诗数据
        //$this->mkPoetAuthor("S"); //exit;bug ok
        $this->mkPoetData("S");


        //生成唐宋诗作者数据
        // $this->mkPoetAuthor("T"); ok
        $this->mkPoetData("T");

        //生成宋词作者数据
        //$this->mkPoemsAuthor();// ok
        //生成宋词数据
        //$this->mkPoemsData();// ok
        //生成论语数据
        //$this->mkLunyuData();// ok
        //生成诗经数据
        //$this->mkShijingData();// ok
    }

    function mkLunyuData() {

        $this->doExecute('delete from lunyu');
        $json  = file_get_contents($this::$lunyuDataPath."/lunyu.json");
        $array = json_decode($json, true);
        printf("Json lun yu total num: %d\n", count($array));
        $sql = "insert into lunyu(chapter, content) values ";
        $value = '';
        foreach ($array as $val) {
            $v = '("'.$val['chapter'].'", "'.implode("|", $val['paragraphs']).'")';
            $value .= $value == '' ? $v : ','.$v;
        }
        $this->doExecute($sql.$value);
        $res = $this->doQuery('select count(*) as total from lunyu');
        $row = $res->fetch_assoc();
        printf("DB lun yu total num: %d\n", $row['total']);
    }
    function mkShijingData() {
        $this->doExecute('delete from shijing');
        $json  = file_get_contents($this::$shijingDataPath."/shijing.json");
        $array = json_decode($json, true);
        printf("Json shi jing total num: %d\n", count($array));
        $sql = "insert into shijing(title, chapter, section, content) values ";
        $value = '';
        foreach ($array as $val) {
            $v = '("'.$val['title'].'", "'.$val['chapter'].'", "'.$val['section'].'", "'.implode("|", $val['content']).'")';
            $value .= $value == '' ? $v : ','.$v;
        }
        $this->doExecute($sql.$value);
        $res = $this->doQuery('select count(*) as total from shijing');
        $row = $res->fetch_assoc();
        printf("DB shi jing total num: %d\n", $row['total']);
    }
    function mkPoemsAuthor() {
        $this->doExecute('delete from poems_author');
        $poemsAuthorJson = file_get_contents($this::$poemsDataPath."/author.song.json");
        $poemsAuthorArray = json_decode($poemsAuthorJson, true);
        printf("Json song ci author total num: %d\n", count($poemsAuthorArray));
        $sql = "insert into poems_author(name, intro_l, intro_s) values ";
        $value = '';
        foreach ($poemsAuthorArray as $val) {
            $v = '("'.$val['name'].'", "'.$this->trimStr($val['description']).'", "'.$this->trimStr($val['short_description']).'")';
            $value .= $value == '' ? $v : ','.$v;
        }
        $this->doExecute($sql.$value);
        $res = $this->doQuery('select count(*) as total from poems_author');
        $row = $res->fetch_assoc();
        printf("DB song ci author total num: %d\n", $row['total']);
    }
    function mkPoemsData() {

        $this->doExecute('delete from poems');
        $res = $this->doQuery('select * from poems_author');
        $authorData = array();
        while (($row = $res->fetch_assoc())) {
            $authorData[$row['name']] = $row['id'];
        }
        $total = 0;
        $num = 0;
        do {
            $fileName = $this::$poemsDataPath.'/ci.song.'.$num.'.json';
            if (!file_exists($fileName)) break;
            $poemsDataJson = file_get_contents($fileName);
            $poemsDataArray = json_decode($poemsDataJson, true);
            $total += count($poemsDataArray);
            printf("start process song ci data file: %s, current total data num: %d\n", $fileName, $total);
            $sql = "insert into poems(author_id, title, content, author) values ";
            $value = '';
            foreach ($poemsDataArray as $val) {
                $authorId = isset($authorData[$val['author']]) ? $authorData[$val['author']] : 0;
                $v = '('.$authorId.', "'.$val['rhythmic'].'", "'.implode("|", $val['paragraphs']).'", "'.$val['author'].'")';
                $value .= $value == '' ? $v : ','.$v;
            }
            $this->doExecute($sql.$value);
            $num += 1000;
        } while(true);
        printf("Json song ci data total num: %d\n", $total);
        $res = $this->doQuery('select count(*) as total from poems');
        $row = $res->fetch_assoc();
        printf("DB song ci data total num: %d\n", $row['total']);
    }
    function mkPoetData($dynasty) {

        $this->doExecute('delete from poetry where dynasty="'.$dynasty.'"');
        $poet = '';
        if ($dynasty == 'T') {
            $poet = 'tang';
        } else if ($dynasty == 'S') {
            $poet = 'song';
        }
        if ($poet == '') return;
        $res = $this->doQuery('select * from poetry_author where dynasty="'.$dynasty.'"');
        $authorData = array();
        while (($row = $res->fetch_assoc())) {
            $authorData[$row['name']] = $row['id'];
        }
        $total = 0;
        $num = 0;
        do {
            $fileName = $this::$poetryDataPath.'/poet.'.$poet.'.'.$num.'.json';
            if (!file_exists($fileName)) break;
            $poetDataJson = file_get_contents($fileName);
            $poetDataArray = json_decode($poetDataJson, true);
            $total += count($poetDataArray);
            printf("start process %s data file: %s, current total data num: %d\n", $poet, $fileName, $total);
            $sql = "insert into poetry(author_id, title, content, yunlv_rule, author, dynasty) values ";
            $value = '';
            foreach ($poetDataArray as $val) {
                $authorId = isset($authorData[$val['author']]) ? $authorData[$val['author']] : 0;
                $v = '('.$authorId.', "'.$val['title'].'", "'.implode("|", $val['paragraphs']).'", "'.implode("|", $val['strains']).'", "'.$val['author'].'", "'.$dynasty.'")';
                $value .= $value == '' ? $v : ','.$v;
            }
            $this->doExecute($sql.$value);
            $num += 1000;
        } while(true);
        printf("Json %s data total num: %d\n", $poet, $total);
        $res = $this->doQuery('select count(*) as total from poetry where dynasty="'.$dynasty.'"');
        $row = $res->fetch_assoc();
        printf("DB %s data total num: %d\n", $poet, $row['total']);
    }
    function mkPoetAuthor($dynasty) {

        $this->doExecute('delete from poetry_author where dynasty="'.$dynasty.'"');
        $poet = '';
        if ($dynasty == 'T') {
            $poet = 'tang';
        } else if ($dynasty == 'S') {
            $poet = 'song';
        }
        if ($poet == '') return;
        $poetAuthorJson = file_get_contents($this::$poetryDataPath."/authors.".$poet.".json");
        $poetAuthorArray = json_decode($poetAuthorJson, true);

        if ($dynasty == 'S') {
            foreach ($poetAuthorArray as $val) {
                $obj = new TsPoetryAuthor();
                $obj->name = $val['name'];
                $obj->intro = $val['desc'];
                $obj->dynasty = $dynasty;
                try {
                    $obj->save();echo 1;
                } catch (\Exception $e) {
                    echo PHP_EOL;
                    echo $obj->name;
                    echo PHP_EOL;
                }
            }
        }else{

            printf("Json %s author total num: %d\n", $poet, count($poetAuthorArray));
            $sql = "insert into poetry_author(`name`, `intro`, `dynasty`) values ";
            $value = '';
            foreach ($poetAuthorArray as $k=>$val) {
                $v = '("'.$val['name'].'", "'.$val['desc'].'", "'.$dynasty.'")';
                $value .= $value == '' ? $v : ','.$v;
            }
            $this->doExecute($sql.$value);
            $res = $this->doQuery('select count(*) as total from poetry_author where dynasty="'.$dynasty.'"');
            $row = $res->fetch_assoc();
            printf("DB %s author total num: %d\n", $poet, $row['total']);

        }
    }
    //============================= 公用函数区
    function doExecute($sql) {

        if (!$this::$db->query($sql)) {
            die("Query Error: ".mysqli_error($this::$db));
        }
    }
    function doQuery($sql) {
        $res = $this::$db->query($sql);
        if (!$res) {
            die("Query Error: ".mysqli_error($this::$db));
        }
        return $res;
    }
    function trimStr($str) {
        return str_replace(["\\", "\"", "\'"], ["", "", ""], $str);
    }
}
