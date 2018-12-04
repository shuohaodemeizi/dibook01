


$(function(){


    getUrl('/api/index','doChinaPopulation');

});

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
