$("#tab tr").mouseover(function () {
    $(this).find("td").addClass("mouseTr");
})
$("#tab tr").mouseout(function () {
    $(this).find("td").removeClass("mouseTr");
})
function showPic(e,sUrl){
    var x,y;
    x = e.clientX;
    y = e.clientY;
    document.getElementById("Layer1").style.left = x+2+'px';
    document.getElementById("Layer1").style.top = y+2+'px';
    document.getElementById("Layer1").innerHTML = "<img width='300px' height='200px' border='0' src=\"" + sUrl + "\">";
    document.getElementById("Layer1").style.display = "";
}
function hiddenPic(){
    document.getElementById("Layer1").innerHTML = "";
    document.getElementById("Layer1").style.display = "none";
}
$(function(){
    $("#loading").ajaxStart(function(){
        showMask();
    });
    $("#loading").ajaxSuccess(function(){
        hideMask();
    });
    $("#loading").ajaxError(function(){
        hideMask();
    });
});
//显示遮罩层
function showMask(){
    $("#loading").css("height",'100%');
    $("#loading").css("width",'100%');//$(document).width()
    $("#loading").show();
}
//隐藏遮罩层
function hideMask(){
    $("#loading").hide();
}
$(".delete").click(function () {
    var value=confirm("确认要删除该用户吗？");
    var _this=$(this);
    if(value == true){
        var id=_this.attr('user');
        $.ajax({
            url:"{:U('Index/delete')}",
            type:'POST',
            data:{id:id},
            success:function (data) {
                if(data.msg == true){
                    _this.parent().parent('tr').remove();
                }else{
                    alert("删除失败");
                }
                //
            }
        })
    }
})



$('.a').on('click',function () {
    var _this=$(this);
    if(_this.text().trim().replace(/\s/g,"")=="未审核"){
        var value=confirm("确认要审核该用户吗？");
        if(value==true){
            var b=_this.attr('user');
            //console.log(b);return;
            $.ajax({
                url:"{:U('Index/check')}",
                type:"POST",
                data:{
                    name:b
                },
                success:function (data) {
                    hideMask();
//                        alert(data.msg);
                    if(data.code=='200'){
                        console.log("已经通过审核");
                        $('a').html("已通过");
                        location.replace(location)
                    }else{
                        console.log(data.msg)
                    }
                },
                error:function (data) {
                    console.log(data.msg)
                    hideMask();
                }
            })
        }
    }
});
