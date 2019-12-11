@extends('layouts.app')

@section('breadcrumb')
    <nav class="breadcrumb">
        <div class="container">
            <i class="Hui-iconfont">&#xe67f;</i>
            <a href="/index.html" class="c-primary">首页</a>
            <span class="c-gray en">&gt;</span>
            <span class="c-gray">{{$category->name}}</span>
        </div>
    </nav>
@endsection

@section('privateContent')


    <ul id="Huifold1" class="Huifold1111111">
    @foreach($list->categorys as $info)

  <li class="item">
    <h4>{{$info->name}}<b>+</b></h4>
    <div class="info" >
        @foreach($info->products as $product)
          <a href="{{$product->url}}" target="_blank" title="{{$product->name}}">{{$product->name}}</a> <br>

          @isset($product->tags)
          @foreach($product->tags as $tag)
              <span class="pull-right"><a href="/t/{{$tag->id}}.html" class=" badge badge-secondary radius">{{$tag->name}}</a></span>
          @endforeach
          @endisset
        @endforeach
    </div>
  </li>


    @endforeach
</ul>

@endsection

@section('privateJs')

@endsection


<script>
    jQuery.Huifold = function(obj,obj_c,speed,obj_type,Event){
    	if(obj_type == 2){
    		$(obj+":first").find("b").html("-");
    		$(obj_c+":first").show()}
    	$(obj).bind(Event,function(){
    		if($(this).next().is(":visible")){
    			if(obj_type == 2){
    				return false}
    			else{
    				$(this).next().slideUp(speed).end().removeClass("selected");
    				$(this).find("b").html("+")}
    		}
    		else{
    			if(obj_type == 3){
    				$(this).next().slideDown(speed).end().addClass("selected");
    				$(this).find("b").html("-")}else{
    				$(obj_c).slideUp(speed);
    				$(obj).removeClass("selected");
    				$(obj).find("b").html("+");
    				$(this).next().slideDown(speed).end().addClass("selected");
    				$(this).find("b").html("-")}
    		}
    	})}
  </script>
  <script>
  $(function(){
	$.Huifold("#Huifold1 .item h4","#Huifold1 .item .info","fast",3,"click"); /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
});

  </script>
