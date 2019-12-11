<?php

namespace App\Console\Commands;

use App\Models\Garbages;
use App\Models\ProductItems;
use App\Models\Topics;
use App\Models\ProductCategorys;
use App\Models\CategoryToCategory;
use App\Models\Products;
use App\Models\ProductToCategory;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use QL\QueryList;
use JonnyW\PhantomJs\Client;
use App\Helpers\Helper;

class WwwIm0xCom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:w0com';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '导入代码巴士分类';

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
     public function handle()
     {
        $list = ProductCategorys::where('id','>',104)->where('id','<=',203)->get();
        foreach($list as $k =>$v){
          self::do('https://im0x.com/M/'.$v->name,$v->id);
        
        }

     }
    public static function do($url='https://im0x.com/M/Algorithm',$parent_id)
    {

      libxml_use_internal_errors(true) ;
      $myXmlString = Helper::curl($url,false,0,1);
      //var_dump($myXmlString);
      $doc = new \DOMDocument();
      // We don't want to bother with white spaces
      $doc->preserveWhiteSpace = false;
      //$doc->loadHTMLFile("testdoc.html");
      $doc->loadHTML($myXmlString);//var_dump($doc);
      $xpath = new \DOMXPath($doc);
      //查找带aconf_edit_section的div元素

      //$query = '//div[@id="navbar"]/ul/li/a'; //--ok
      //$entries = $xpath->query($query);
      //self::cage($xpath,$query);


      // 添加子分类，子分类+数据
      // $entries=$xpath->query('//title');
      // $name = $entries[0]->nodeValue;
      // $name = (str_replace(' - 代码巴士','',$name));
      // $name = (str_replace(PHP_EOL,'',$name));var_dump($name);exit;
      // $obj = ProductCategorys::where("name",$name)->first();
      // $parent_id = $obj->id;

      self::child_cate($xpath, $parent_id);
    }


    static function  cage(&$xpath,$query){
      $entries=$xpath->query($query);
      foreach ($entries as $entry) {
        //print_r($entry->attributes[0]); ==> href
          //echo  " {$entry->nodeValue}<br/>";
          $a[] = $entry->nodeValue;
          //print_r($entry->childNodes[0]->nodeValue);
      }
      //echo domNodeList_to_string($entries);
      foreach ($a as $key => $value) {
         $e = ProductCategorys::where('name',$value)->exists();
         if($e){
           echo 'exists';
           continue;
         }
         $new = new ProductCategorys();
         $new->name = $value;
         $new->is_show =1;
         $new->save();
         echo '添加主分类';
      }
    }

    // $rs = $dom->getElementById("test");
    // echo $rs->nodeValue;
    //   print_r($entries->save('xxx.html'));
    static function child_cate(&$xpath,$parent_id,$query='//div[@class="content"]') { ////div[@class="content"]
      $entries=$xpath->query($query);
      foreach ($entries as $entry) {

        //var_dump($entry->textContent);exit;
        $arr = explode(PHP_EOL,$entry->textContent);
        foreach($arr as $k=>$v)
        {
          $str = trim($v);
          $str = str_replace('- ','',$str);
          if(trim($v)==''){
            continue;
          }
          if (strpos($str, 'http') === false)
          {
              $name = (str_replace(' - ','',$str));
              $e = ProductCategorys::where('name',$name)->where('pid',$parent_id)->first();
              if(!$e){
                $e = new ProductCategorys();
                $e->name = $name;
                $e->is_show =1;
                $e->pid = $parent_id;
                $e->save();
                echo '+子分类ID'.$name.$e->id.'-'.$parent_id.PHP_EOL;
              }else{
                echo '=子分类ID'.$name.$e->id.'-'.$parent_id.PHP_EOL;
              }

          }
          else
          {
              //list($name,$carr) =  explode('http',$str);
              list($k1,$k2) = explode('http',$str);
              $obj = Products::where('name',$k1)->first();
              if(!$obj){
                $obj = new Products();
                $obj-> type = 'link';
                $obj-> name = $k1;
                $obj-> url = 'http'.$k2;
                $obj-> is_show = 1;
                $obj->save();
                echo '+加文章';
              }

              $obj2 = ProductToCategory::where('product_id',$obj->id)->where('category_id',$e->id)->exists();
              if(!$obj2){
                $obj2 = new ProductToCategory();
                $obj2->product_id = $obj->id;
                $obj2->category_id = $e->id;
                $obj2->save();
                echo '+加关联('.$obj->id.','.$e->id.')'.PHP_EOL;
              }
          }

        }

         // var_dump($arr);exit;
         //  // //div[@class="content"]/span[@class="column1"]
         // $name = (str_replace(' - ','',$value));
         // $e = ProductCategorys::where('name',$name)->where('pid',$parent_id)->first();
         // if(!$e){
         //   $e = new ProductCategorys();
         //   $e->name = $name;
         //   $e->is_show =1;
         //   $e->pid = $parent_id;
         //   $e->save();
         //   echo '+子分类ID='.$name.$e->id.'-'.$parent_id.PHP_EOL;
         // }else{
         //   echo '=子分类ID='.$name.$e->id.'-'.$parent_id.PHP_EOL;
         // }
         // //$query = ""; 取默认
         // $cate_id = $e->id;
         // self::row($xpath,$cate_id);
      }

    }
    static function row(&$xpath,$cate_id,$query='//div[@class="content"]/span[@class="column2"]/ul/li'){
      $entries=$xpath->query($query);
      foreach ($entries as $entry) {
          $title = $entry->nodeValue;
          var_dump($title);
          list($k1,$k2) = explode('http',$title);
          $obj = Products::where('name',$k1)->first();
          if(!$obj){
            $obj = new Products();
            $obj-> type = 'link';
            $obj-> name = $k1;
            $obj-> url = 'http'.$k2;
            $obj-> is_show = 1;
            $obj->save();
            echo '+加文章';
          }

          $obj2 = ProductToCategory::where('product_id',$obj->id)->where('category_id',$cate_id)->exists();
          if(!$obj2){
            $obj2 = new ProductToCategory();
            $obj2->product_id = $obj->id;
            $obj2->category_id = $cate_id;
            $obj2->save();
            echo '+加关联('.$obj->id.','.$cate_id.')'.PHP_EOL;
          }

      } exit;

    }
}
