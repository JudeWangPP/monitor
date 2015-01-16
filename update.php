<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<title>o(∩_∩)o </title>
	

	<style>.file-input-wrapper { overflow: hidden; position: relative; cursor: pointer; z-index: 1; }
	.file-input-wrapper input[type=file], .file-input-wrapper input[type=file]:focus, 
	.file-input-wrapper input[type=file]:hover { position: absolute; top: 0; left: 0; cursor: pointer; opacity: 0; filter: alpha(opacity=0); z-index: 99; outline: 0; }
	.file-input-name { margin-left: 8px; }
	
	</style>
	<link rel="stylesheet" href="js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css" id="style-resource-1">
	<link rel="stylesheet" href="css/font-icons/entypo/css/entypo.css" id="style-resource-2">
	<link rel="stylesheet" href="css/bootstrap-min.css" id="style-resource-4">
	<link rel="stylesheet" href="css/neon-core-min.css" id="style-resource-5">
	<link rel="stylesheet" href="css/neon-theme-min.css" id="style-resource-6">
	<link rel="stylesheet" href="css/neon-forms-min.css" id="style-resource-7">
	<link rel="stylesheet" href="css/erhuo.css" >
	<link rel="stylesheet" href="css/alert.css" >
	<script type=text/javascript src="js/jquery-1.8.3.min.js"></script>
 	<script src="js/bootstrap.js"></script>
 	
</head>
<?php require_once "class.db.Channel.php";
$id=$_GET["id"];
$db=new ChannelDB();
$qop=$db->selectOneChannelNumber(" id=".$id);
// print_r($qop);
?>
<body class="page-body loaded" >
<div class="page-container123">
<span class="heading" >　测试部酒店组 信息修改</span><br/><br/>
<form action="man.php?action=update" id="add_form" method="post">
	<input type="hidden"  name="id" value="<?php echo $id; ?>" />
	<table class='table table-bordered linetable'>
	
	<tr><td width = "85"><label for="channel_name">尊姓大名</label></td>
		<td width = "200"><input type="text" class="xax" id="channel_name" name="channel_name" value="<?php echo $qop["channel_name"]; ?>" maxlength="32"/></td>
		<td class='tip' data_tip="channel_name"></td>
	</tr>
	<tr><td><label for="promotion_team">所属小组</label></td>
		<td width = "200"><input type="text" class="xax" id="team_name" name="team_name" value="<?php echo $qop["team_name"]; ?>" maxlength="32"/></td>
		<td class='tip' data_tip="team_name"></td>
	</tr>
	<tr><td><label for="payment_method">工作职责</label></td>
		<td width = "200"><input type="text" class="xax" id="work" name="work" value="<?php echo $qop["work"]; ?>" maxlength="1132"/></td>
		<td class='tip' data_tip="work"></td>
	</tr>
	<tr><td><label for="cooperation_mode">个人特长</label></td>
		<td width = "200"><input type="text" class="xax" id="person" name="person" value="<?php echo $qop["person"]; ?>" maxlength="1132"/></td>
		<td class='tip' data_tip="person"></td>
	</tr>
	<tr><td><label for="cooperation_mode">联系方式</label></td>
		<td width = "200"><input type="text" class="xax" id="tele" name="tele" value="<?php echo $qop["tele"]; ?>" maxlength="32"/></td>
		<td class='tip' data_tip="tele"></td>
	</tr>

	
	</table>
	<input id="submit" type="submit" value="提交" />
	<a href="index.php" id="to_select">返回</a>
	
</form>
	
</div>	


</div>
<div id="alert_div" style="position: absolute; z-index: 10001; top: 250px; left: 40%; visibility: hidden;" class="W_layer">
 <div class="bg">
  <table cellspacing="0" cellpadding="0" border="0">
    <tr>
     <td style="width:280px;">
      <div class="content">
       <div class="title" style="cursor: move;"><span>提示信息</span></div>
       <a title="关闭" class="W_close" href="index.php"><b>×</b></a>
       <div class="detail layer_forward" >
        <div style="height:18px;"></div>
        <p class="alert_content">渠道修改 <a style="font-size:25px;color:green;font-weight:900">成功</a>！</p>
       </div>
      </div>
    </td>
   </tr>
  </table>
 </div>
</div>


<script>
(function($){	
	function check(){
		var return_val=1;
		var inputs = $(".xax");
		$(inputs).each(function(){
			if($(this).attr("name")=="channel_name"){
				if($(this).val()==""){
					$("input[name='channel_name']").addClass("bad");
					$("td[data_tip='channel_name']").html("* 名称不能为空");
					return_val=0;
				}
			}else if($(this).attr("name")=="team_name"){
				if($(this).val()==""){
					$("input[name='team_name']").addClass("bad");
					$("td[data_tip='team_name']").html("* 所属小组不能为空");
					return_val=0;
				}
			}else if($(this).attr("name")=="work"){
				if($(this).val()==""){
					$("input[name='work']").addClass("bad");
					$("td[data_tip='work']").html("* 工作职责不能为空");
					return_val=0;
				}
			}else if($(this).attr("name")=="person"){
				if($(this).val()==""){
					$("input[name='person']").addClass("bad");
					$("td[data_tip='person']").html("* 个人特长不能为空");
					return_val=0;
				}
			}else if($(this).attr("name")=="tele"){
				if($(this).val()==""){
					$("input[name='tele']").addClass("bad");
					$("td[data_tip='tele']").html("* 联系方式不能为空");
					return_val=0;
				}
			};
		});
		return return_val;
	};
	
	$("#edit_des").val($("#edit_des").attr("placeholder"));
	$("#submit").click(function(e){
		e.preventDefault();
		if(check() == 0){
			return;
		}
		$.post("man.php?action=add",$("#add_form").serialize(),function(data){
			if(data == 1){
				alert("修改成功，谢谢!");
				window.location.href="index.php";
			}else if(data == 2){
				alert("已添加");
			}else{
				alert("添加信息失败，请稍后重试！");
			};
		});
	});
	$("input").blur(function(){
		$(this).removeClass("bad");
		$(this).parents("tr").children("td[class='tip']").html("");
	});
	$("select").blur(function(){
		$(this).removeClass("bad");
		$(this).parents("tr").children("td[class='tip']").html("");
	});
	
		
})(jQuery);


</script>

</body>

