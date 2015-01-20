<?php 
	$ip=$_GET["ip"];
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>o(∩_∩)o</title>
	<link rel="stylesheet" href="css/my.css">
	<script type=text/javascript src="js/jquery-1.8.3.min.js"></script>

</head>
<body>
	<input id="ip" type="text" value="<?php echo $ip;?>" maxlength="15" style="display: none">
	<table>
		<tr>
			<td>删除指定目录下所有文件:</td>
			<td><input id="delDir" class= "editbox" type="text" value="/home/tester/deltest/" maxlength="30"></td>
			<td><input id="delDirBut" type="button" value="删除" class="but"></td>
			<td data_tip="delRes"></td>
		</tr>
		<tr height = "60">
			<td align = "right">执行常用简单的Linux命令:</td>
			<td><input id="execMl" class= "editbox" type="text" value="cd / ; ll" maxlength="300"></td>
			<td><input id="execMlBut" type="button" value="执行" class="but"></td>
			<td><font size='1' color='grey'>可同时输入多个关联命令</font></td>
		</tr>
	</table>
	<div>执行结果:</div>
	<div style="width:100%;height:100%;border:1px solid #082E54">
		<div style="border:10px solid #FFFFFF" id = "execRes"><?php echo $ip;?></div>
	</div>
	
<script>
	$(function(){ 
		$("#delDirBut").click(function(e){
			$("td[data_tip='delRes']").html("");
			var msg = "确认要删除\n\n　　　机器 " + $("#ip").val() +"\n　　　路径 " + $("#delDir").val() + "\n\n　　　下所有内容吗？";
			if (!confirm(msg)) {
	            return 
	        }
			$.get("man.php?type=rm",{ip:$("#ip").val(),deldir:$("#delDir").val()},function(data){
				if(data == ''){
					$("td[data_tip='delRes']").html("<font size='1' color='green'>执行删除命令成功!</font>");
				}else{
					$("td[data_tip='delRes']").html("<font size='1' color='red'>" + data + "</font>");
				}
			});
		});
		
		$("#execMlBut").click(function(e){
			$("#execRes").html("执行中。。。");
			$("#execMl").select();  //下次输入不用先删除本次内容
			$.get("man.php?type=exec",{ip:$("#ip").val(),execml:$("#execMl").val()},function(data){
				if(data == ''){
					$("#execRes").html("命令不正确或者命令无返回结果");
				}else{
					$("#execRes").html(data);
				}
			});
		});
		$("body").keydown(function() {
			if (event.keyCode == "13") {//keyCode=13是回车键
				$('#execMlBut').click();
			}
		});
	});
</script>
</body>
</html>

