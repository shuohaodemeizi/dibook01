<div class="sideBox ">
    <ul class="nav navbar-nav pt-20">
        <li><a href="/">首页</a></li>
        <li class="dropDown dropDown_hover">



            <a id="menu_2" href="javascript:;" class="dropDown_A">分类 <i class="Hui-iconfont">&#xe6d5;</i></a>
                @isset($common_categorys)
                @foreach($common_categorys as $cate)

                <a href="/c/{{$cate->id}}.html" target="_blank">&nbsp;&nbsp;{{$cate->name}}</a>

                @endforeach
                @endisset
        </li>
        <li><a href="/s/">搜索</a></li>
        <li><a href="/">关于我们</a></li>

    </ul>
</div>