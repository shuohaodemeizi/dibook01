


$(function(){
    var reg = new RegExp("/([a-z]*)/([0-9]*).html","i");
    var res = window.location.pathname.substr(0).match(reg);
    var type = res[1];
    var id = res[2];
    var page = GetQueryString('page');
    var page = (page==undefined)?1:page;
    //window.console.log(page);

    getUrlForList('/api/'+type+'/'+id,'doChinaPopulation');

});

function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)","i");
    var r = window.location.search.substr(1).match(reg);
    if (r!=null) return (r[2]); return null;
}

function getUrlForList(src,doaction) {
    //window.console.log(src);
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
                dolist(data);

            }else{
                console.log(src+":请求失败:"+res.msg);
            }
        },
        error: function () {
            console.log(src+":请求超时:"+res.msg);
        }
    });

    return;
}

function getUrl(src,doaction) {
    //console.log(src);
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
                doChinaPopulation(data);
                doWorldHealth(data);

            }else{
                console.log(src+":请求失败:"+res.msg);
            }

        },
        error: function () {
            console.log(src+":请求超时:"+res.msg);
        }
    });

    return;
}

function dolist(data) {
    if(data != undefined) {
        var str='';
        var list = data.list;
        if(list) {
            for (i in list) {
                console.log(i)
                str += "<li>\
                    <div class=\"so-header\"><a href=\"/p/"+list[i].id+".html\" target=\"_blank\" title=\""+list[i].name+"\">"+list[i].name+"</a></div>\
                    <div class=\"so-body\">\
                    <div class=\"so-cont\"> </div>\
                </div>\
                <div class=\"so-footer\">\
                    <span class=\"pull-left\">最后更新日期："+list[i].updated_at+"</span>\
                <span class=\"pull-right\">"+list[i].categorys[0].name+"</span>\
                </div>\
                </li>";
            }
            $(".col-search-list>ul").append(str);

        }
    }
}

function doChinaPopulation(data){
    var str;
    if(data != undefined) {
        var chinaPopulation = data.chinaPopulation;
        if(chinaPopulation) {
            for (i in chinaPopulation) {
                str += "<tr><th class=\"col1 text-r\">"+chinaPopulation[i].cp+"</th><td class=\"col2\">"+chinaPopulation[i].data_name+"</td></tr>"
            }
            $("#chinaPopulation>div>table>tbody").html(str);
        }
    }
}
function doWorldHealth(data){
    var str;
    if(data != undefined) {
        var worldHealth = data.worldHealth.list;
        console.log(worldHealth);
        if(worldHealth) {
            for (i in worldHealth) {
                str += "<tr><th class=\"col1 text-r\">"+worldHealth[i].cp+"</th><td class=\"col2\">"+worldHealth[i].data_name+"</td></tr>"
            }
            $("#worldHealth>div>table>tbody").html(str);
            var str2 = data.worldHealth.remark;
            str2 = "<tr><td class=\"c-999\" colspan=\"2\">"+str2+"</td></tr>"
            $("#worldHealth>div>table>tfoot").html(str2);

            $("#worldHealth>div>i").attr('data-original-title',data.worldHealth.source);

        }
    }
}
