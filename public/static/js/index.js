


$(function(){


    getUrl('/api/index','doChinaPopulation');

});

function getUrl(src,doaction) {
    console.log(src);
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
