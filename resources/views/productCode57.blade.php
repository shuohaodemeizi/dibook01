@extends('layouts.app')

@section('privateContent')
    <div class="panel panel-default mt-20" id="worldHealth">
        <div class="panel-header">中国2018世界卫生组织 </div>
        <div class="panel-body">
            <table class="table table-border table-bordered table-striped mt-20">
                <tbody></tbody>
                <tfoot></tfoot>
            </table>

            <i class="icon Hui-iconfont" data-toggle="tooltip" data-placement="top" title="" data-original-title=".."></i>


        </div>
    </div>
@endsection

@section('privateJs')
    <script type="text/javascript" src="/static/js/productCode.js"></script>
    <script>
        $(function(){

            var src = "/pcode?pcode=WorldHealth";
            $.ajax({
                type: "GET",
                dataType: "JSON",
                contentType: "application/json",
                url: src,
                data: "",
                success: function (res) {
                    if (res.code==200) {
                        //return res.msg;
                        data = res.data;
                       // doChinaPopulation(data);
                        doWorldHealth(data);

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