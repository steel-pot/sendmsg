<?php if(!class_exists("View", false)) exit("no direct access allowed");?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!--禁止缩放-->
<meta content="yes" name="apple-mobile-web-app-capable" />
    <!--全屏显示-->
<meta content="telephone=no" name="format-detection" />
    <!--告诉设备忽略将页面中的数字识别为电话号码-->
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <!-- 隐藏状态栏-->
<link href="<?php echo I; ?>/main/css/baes.css" rel="stylesheet" type="text/css">
<title>认证专题</title>
</head>
<style>
    #InputBox input{
        width: 114%;
        height: 40px;
        opacity: 0;
        cursor: pointer;
        position: absolute;
        top: 0;
        left: -14%;

    }

    .imgContainer img{
        width: 100%;
        height: 150px;
        cursor: pointer;
    }
    .imgContainer p{
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        height: 30px;
        background: black;
        text-align: center;
        line-height: 30px;
        color: #f6d51c;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        display: none;
    }
    .imgContainer:hover p{
        display: block;
    }

    .mask {
        position: absolute; top: 0px; filter: alpha(opacity=60); background-color:#333;
        background-image: url(<?php echo I; ?>/main/images/LNzcS0w.gif");
        background-position: center;
        background-repeat: no-repeat;
        z-index: 1002; left: 0px;
        opacity:0.9; -moz-opacity:0.9;
        font-size: 30px;
        text-align: center;
        width:270px;
        color: #f6d51c;
    }
	.btn{
		 
	}
</style>
<body>
<div class="bg">
  <div class="text_box">
      <form  id="form1"  method="post" enctype="multipart/form-data">
          <ul>
              <li><input type="text" class="text" name="username"  id="username"><i><img src="<?php echo I; ?>/main/images/icon_1.png"></i><a href="#" id="usernameCheck">用户名</a></li> 
              <li><input type="text" class="text" name="phone" id="phone"><i><img src="<?php echo I; ?>/main/images/icon_3.png"></i><a href="#" id="phoneCheck">手机号码</a></li>
              <li><input type="text" class="text" name="vcode" id="vcode"><i><img src="<?php echo I; ?>/main/images/icon_5.png"></i><a class="btn" href="#" id="vcodeCheck">获取验证码</a></li>
              <li>	<select class="text" name="deposit" id="deposit"> 
					<option value=" ">请选择存款总计</option>
					<?php if(!empty($depositList)){ $_foreach_v_counter = 0; $_foreach_v_total = count($depositList);?><?php foreach( $depositList as $k => $v ) : ?><?php $_foreach_v_index = $_foreach_v_counter;$_foreach_v_iteration = $_foreach_v_counter + 1;$_foreach_v_first = ($_foreach_v_counter == 0);$_foreach_v_last = ($_foreach_v_counter == $_foreach_v_total - 1);$_foreach_v_counter++;?>
					<option value="<?php echo htmlspecialchars($k, ENT_QUOTES, "UTF-8"); ?>"><?php echo htmlspecialchars($v, ENT_QUOTES, "UTF-8"); ?></option> 
					<?php endforeach; }?>
					</select>  <i><img src="<?php echo I; ?>/main/images/icon_2.png"></i> </li>
          </ul>
      </form>
      <div class="ts" id="ts">将根据您的存款总计来发放奖励,客服人员会核对信息是否正确,请如实填写哦.</div>
       
      <div id="btn" ><a href="#">确认提交申请</a></div>


  </div>
</div>
<div id="mask" class="mask"></div>
</body>
</html>


<script type="text/javascript" src="<?php echo I; ?>/main/js/jquery.min.js"></script>
<script> 
	var btime;
	var checkUsername=function () {
        var name = $(this).val();
        if (name === null || name === undefined || name === "") {
            $("#usernameCheck").css("color","red");
            $("#usernameCheck").text("*用户名不能为空*");
            return false
        }else{
            $("#usernameCheck").css("color","#80581f");
            $("#usernameCheck").text("用户名√");
        }
    };
	
    $("#username").mouseout(checkUsername)
	
	var checkPhone=function () {
        var phone = $(this).val();
        if (phone === null || phone === undefined || phone === "") {
            $("#phoneCheck").css("color","red");
            $("#phoneCheck").text("*请输入手机号*");
            return false;
        }else if(!(/^1[3|4|5|7|8]\d{9}$/.test(phone))){
             $("#phoneCheck").css("color","red");
             $("#phoneCheck").text("*电话号码不合法*");return false;
         }else{
		
            $("#phoneCheck").css("color","#80581f");
            $("#phoneCheck").text("手机号码√");
        }
    };
    $("#phone").mouseout(checkPhone);
	
    //显示遮罩层
    function showMask(){
        $("#mask").css("height",'100%');
        $("#mask").css("width",'100%');//$(document).width()
        $("#mask").show();
    }
    //隐藏遮罩层
    function hideMask(){
        $("#mask").hide();
    }
    //验证码
    $("#vcodeCheck").click(function () {
         var ph=$("#phone").val();
         if(ph===null||ph===undefined||ph===""){
             $("#phoneCheck").css("color","red");
             $("#phoneCheck").text("*请输入电话号码*");return false;
         }
         if(!(/^1[3|4|5|7|8]\d{9}$/.test(ph))){
             $("#phoneCheck").css("color","red");
             $("#phoneCheck").text("*电话号码不合法*");return false;
         }
		 
		 
		 
        $("#vcodeCheck").css("color","#80581f");
        $("#vcodeCheck").text("发送中");
        $("#vcodeCheck").css("pointer-events","none");
         $.ajax({
             url:"<?php echo url(array('c'=>'main', 'a'=>'sendvcode', ));?>",
             type:'POST',
             data:{phone:ph},
             success:function (data) {
                 if(data.result!=1)
				 {
				  $("#vcodeCheck").text(data.msg);
				  $("#vcodeCheck").css("color","red");
				  return ;
				 }
                 var seconds=60;
                 btime=setInterval(function (){
						 cansend=0;
						 $("#vcodeCheck").text("再次发送("+seconds+")");
						 if(seconds<=0){
							 clearInterval(btime);
							 $("#vcodeCheck").text("获取验证码");
							 $("#vcodeCheck").css("pointer-events","auto");
							 return;
						 }
						seconds -=1;
                 },1000);
             }
         })
    });
	
	
     $("#getCheck").click(function(){
         $("#vcodeCheck").append("#getCheck");
     })

	$("#deposit").change(function(){
		$("#deposit").css("color","#80581f"); 
	});	

     $("#vcode").change(function(){
		$("#vcodeCheck").css("color","#80581f"); 
		 $("#vcodeCheck").text("获取验证码");
	});	
    $("#btn").click(function () {
		clearInterval(btime);
        var username = $("#username").val();
        var phone = $("#phone").val();  
        var vcode = $("#vcode").val();
		var deposit = $("#deposit").val();
		
		
        if (vcode === null || vcode === undefined || vcode === "") {
            $("#vcodeCheck").css("color","red");
            $("#vcodeCheck").text("*请输入验证码*");
            return false
        }
		 
		if (deposit === null || deposit === undefined || deposit === ""||deposit === " ") {
            $("#deposit").css("color","red");  
            return false;
        } 
        $.post("<?php echo url(array('c'=>'main', 'a'=>'add', ));?>",$("form").serialize(),function(rs){
			  if(rs.result!=1)
			  {
				if(rs.key=='deposit')
				{
					$("#deposit").css("color","red");   
				}else{
					$("#"+rs.key+"Check").css("color","red");  
					$("#"+rs.key+"Check").text(rs.msg);
				}
			  }
			  alert(rs.msg);
			 
		})

    })
     



</script>