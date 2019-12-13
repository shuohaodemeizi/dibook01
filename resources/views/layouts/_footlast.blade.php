<!--普通弹出层-->
<div id="modal-demo" class="modal fade middle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content radius">
            <div class="modal-header">
                <h3 class="modal-title">对话框标题</h3>
                <a class="close" data-dismiss="modal" aria-hidden="true" href="javascript:void();">×</a>
            </div>
            <div class="modal-body">
                <p>对话框内容…</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">确定</button>
                <button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/lib/jquery-ui/1.9.1/jquery-ui.min.js"></script>
<script type="text/javascript" src="/static/h-ui/js/H-ui.js"></script>
<script type="text/javascript" src="/lib/jquery.SuperSlide/2.1.1/jquery.SuperSlide.min.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/lib/jquery.validation/1.14.0/messages_zh.min.js"></script>


<script type="text/javascript">
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

    //弹窗
    function modaldemo(){
        $("#modal-demo").modal("show");
    }
    //消息框
    function modalalertdemo(){
        $.Huimodalalert('我是消息框，2秒后我自动滚蛋！',2000);
    }
    $(function(){
        $.Huifold("#Huifold1 .item h4","#Huifold1 .item .info","fast",3,"click"); /*5个参数顺序不可打乱，分别是：相应区,隐藏显示的内容,速度,类型,事件*/
        /*
        1	只打开一个，可以全部关闭
        2	必须有一个打开
        3	可打开多个
        */


        $(".input-text,.textarea").Huifocusblur();

        //幻灯片
        jQuery("#slider-3 .slider").slide({mainCell:".bd ul",titCell:".hd li",trigger:"click",effect:"leftLoop",autoPlay:true,delayTime:700,interTime:3000,pnLoop:false,titOnClassName:"active"});

        $(".panel").Huifold({
            titCell:'.panel-header',
            mainCell:'.panel-body',
            type:1,
            trigger:'click',
            className:"selected",
            speed:"first",
        });

        //邮箱提示
        $("#email").emailsuggest();

        //checkbox 美化
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        //日期插件
        $("#datetimepicker").datetimepicker({
            format: 'yyyy-mm-dd',
            minView: "month",
            todayBtn:  1,
            autoclose: 1,
            endDate : new Date()
        }).on('hide',function(e) {
            //此处可以触发日期校验。
        });

        /*+1 -1效果*/
        $("#spinner-demo").Huispinner({
            value:1,
            minValue:1,
            maxValue:99,
            dis:1
        });

        $(".textarea").Huitextarealength({
            minlength:10,
            maxlength:200.
        });

        $("#demoform").validate({
            rules:{
                email:{
                    required:true,
                    email:true,
                },
                username:{
                    required:true,
                    minlength:4,
                    maxlength:16
                },
                telephone:{
                    required:true,
                    isMobile:true,
                },
                password:{
                    required:true,
                    isPwd:true,
                },
                password2:{
                    required:true,
                    equalTo: "#password"
                },
                sex:{
                    required:true,
                },
                datetimepicker:{
                    required:true,
                },
                checkbox2:{
                    required:true,
                },
                city:{
                    required:true,
                },
                website:{
                    required:true,
                    url:true,
                },
                beizhu:{
                    maxlength:500,
                }
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
                $("#modal-shenqing-success").modal("show");
                $(form).ajaxSubmit();
            }
        });

        //选项卡
        $("#HuiTab-demo1").Huitab({
            index:0
        });

        $("#Huitags-demo1").Huitags();

        //返回顶部
        $.Huitotop();

        //hover效果
        $('.maskWraper').Huihover();

        //星级评价
        $("#star-1").raty({
            hints: ['1','2', '3', '4', '5'],//自定义分数
            starOff: 'iconpic-star-S-default.png',//默认灰色星星
            starOn: 'iconpic-star-S.png',//黄色星星
            path: 'static/h-ui/images/star',//可以是相对路径
            number: 5,//星星数量，要和hints数组对应
            showHalf: true,
            targetKeep : true,
            click: function (score, evt) {//点击事件
                //第一种方式：直接取值
                $("#result-1").html('你的评分是'+score+'分');
            }
        });

        $( ".ui-sortable" ).sortable({
            //connectWith: ".panel",
            items:".panel",
            handle: ".panel-header",
            //delay: 300, //时间延迟
            //distance: 15, //距离延迟
            placeholder: "ui-state-highlight", //占位符样式
            update: function(event, ui){

            }
        }).disableSelection();

        var _bodyHeight = $(window).height();
        var _doch = $(document).height();
        $(".containBox").height(_bodyHeight);

        /*左右滑动菜单*/
        $(".JS-nav-toggle").click(function() {
            $("body").addClass('sideBox-open');
            $(".containBox-bg").height(_bodyHeight).show();
        });
        $(".containBox-bg").click(function() {
            $(this).hide();
            $("body").removeClass('sideBox-open');
        });
    });
</script>
