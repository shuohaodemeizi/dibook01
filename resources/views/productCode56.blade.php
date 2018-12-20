@extends('layouts.app')

@section('privateContent')
    <div class="panel panel-default mt-20" id="chinaPopulation">
        <div class="panel-header">中国实时人口时钟</div>
        <div class="panel-body">
            <table class="table table-border table-bordered table-striped mt-20">
                <tbody>
                <tr><th class="col1 text-r">0</th><td class="col2">目前的人口</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">目前的男性人口 (51.9%)</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">当前女性人口 (48.1%)</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">今年出生的人数</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">今天出生的人数</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">今年死亡的人数</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">今天死亡的人数</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">净迁移今年</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">今天的净迁移</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">人口增长今年</td></tr>
                <tr><th class="col1 text-r">0</th><td class="col2">人口增长的今天</td></tr></tbody>
            </table>
        </div>
    </div>
@endsection

@section('privateJs')
    <script type="text/javascript" src="/static/js/productCode.js"></script>
    <script>
        $(function(){

            var src = "/pcode?pcode=ChinaPopulation";
            $.ajax({
                type: "GET",
                dataType: "JSON",
                contentType: "application/json",
                url: src,
                data: "",
                success: function (res) {
                    if (res.code==200) {
                        data = res.data;
                        doChinaPopulation(data);
                    }else{
                        console.log(src+":请求失败:"+res.msg);
                    }
                },
                error: function () {
                    console.log(src+":请求超时:"+res.msg);
                }
            });

        });
    </script>
@endsection

@section('breadcrumb')
    @endsection