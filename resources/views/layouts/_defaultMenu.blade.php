<header class="navbar-wrapper">
    <div class="navbar navbar-black navbar-fixed-top">
        <div class="container cl">
            <a class="logo navbar-logo hidden-xs" href="/">图开森</a>
            <a class="logo navbar-logo-m visible-xs" href="/">图开森</a>
            <a href="javascript:;" class="nav logo navbar-logo-m visible-xs">
                <form id='searchForm'method="get" action="/s/">
                    <input type="text" placeholder="请输入关键词" class="input-text ac_input" name="kw" value="" autocomplete="off" style="width:200px">
                    <i class="Hui-iconfont" onclick="javascript: document.getElementById('searchForm').submit(); ">
                        &#xe709;
                    </i>
                </form>
            </a>
            <a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs JS-nav-toggle" href="javascript:;">&#xe667;</a>

            <nav class="nav navbar-nav nav-collapse" role="navigation" id="Hui-navbar">
                <ul class="cl">

                    <li id="Huinav_1"> <a href="/">首页</a> </li>
                    <li class="dropDown dropDown_hover">
                        <a href="javascript:;" class="dropDown_A">分类 <i class="Hui-iconfont">&#xe6d5;</i></a>
                        <ul class="dropDown-menu menu radius box-shadow">
                            @isset($common_categorys)
                            @foreach($common_categorys as $cate)
                                <li>
                                    <a href="/c/{{$cate->id}}.html" target="_blank">{{$cate->name}}</a>
                                </li>
                                @endforeach
                            @endisset
                        </ul>
                    </li>
                    <li class="clearfix">
                        <a href="javascript:;">
                            <form id='searchForm'method="get" action="/s/">
                                <input type="text" placeholder="请输入关键词" class="input-text ac_input radius" name="kw" value="" id="search_text" autocomplete="off" style="width:250px">
                                <i class="Hui-iconfont" onclick="javascript: document.getElementById('searchForm').submit(); ">
                                    &#xe709;
                                </i>
                            </form>
                        </a>
                    </li>


                </ul>
            </nav>
            <nav class="navbar-userbar visible-xs">

            </nav>
        </div>
    </div>
</header>


