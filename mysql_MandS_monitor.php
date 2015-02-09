<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>o(∩_∩)o</title>

<link rel="stylesheet" href="css/my.css">
<link rel="stylesheet" href="css/table.css">
<script type=text/javascript src="js/jquery-1.8.3.min.js"></script>

</head>
<body>
	<table>
		<tr>
			<td>主从同步监控:</td>
			<td><small><small>网段</small></small><select id="envgroup">
				<?php 
				 for($i=61;$i<80;$i++){
				 	echo "<option value=$i>$i</option>";
				 }
				?>
			</select></td>
			<td><small><small>端口</small></small><select id="port">
				<option value=6015>6015</option>
				<?php 
				 for($i=6026;$i<6031;$i++){
				 	echo "<option value=$i>$i</option>";
				 }
				?>
			</select></td>

			<td><input id="ip" class="but" type="button" value="检查"></td>
			<td><input id="aotofrush" class="but" onclick="aotofrush();" type="button" value="开启自动刷新"></td><td>|</td>
			
			<td><input id="showup" class="but" type="button" onclick = "showUP();"value="指定帐号密码"></td>
			<td><input id="mysqlusername" class = "editboxmini" type="text" value="liangyong.guo"></td>
			<td><input id="mysqlpassword" class = "editboxmini" type="password" value="123456"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td><div id="content" class="content">请选择查询的网段和端口</div></td>
		</tr>
	</table>

<script>
	$(function(){ 
		$("#ip").click(function(e){
			$("#content").html("加载中，请等待。。。");
			$.ajaxSetup({ cache: false }); //IE浏览器会对相同ajax请求做缓存，该设置为设置不缓存
			$.get("man.php?type=mands",{group:$("#envgroup").val(),port:$("#port").val(),user:$("#mysqlusername").val(),pass:$("#mysqlpassword").val()},function(data){
				if(data == '0'){
					$("#content").html("该网段和端口下未建立主从关系");
				}else{
					$("#content").html(data);
				}
			});
		});
	});
	function fixSlaveSqlStatus(){
		$.ajaxSetup({ cache: false }); //IE浏览器会对相同ajax请求做缓存，该设置为设置不缓存
		$.get("man.php?type=fix",{group:$("#envgroup").val(),port:$("#port").val(),user:$("#mysqlusername").val(),pass:$("#mysqlpassword").val()},function(data){
			$("#ip").trigger('click');
		});
	}
	function allSlaveStatus(){
		$('#allSlaveStatus').attr('disabled',true);
		$.ajaxSetup({ cache: false }); //IE浏览器会对相同ajax请求做缓存，该设置为设置不缓存
		$.get("man.php?type=allmands",{group:$("#envgroup").val(),port:$("#port").val(),user:$("#mysqlusername").val(),pass:$("#mysqlpassword").val()},function(data){
			$("#content").append(data);
		});
	}
	function aotofrush(){
		$('#aotofrush').attr('value','自动刷新中...');
		$('#aotofrush').attr('disabled',true);
		$('#aotofrush').addClass("disabled");
		$('#ip').trigger('click');
		setTimeout("aotofrush();",5000);
	}
	function showUP(){
		$("#showup").hide();
		$(".editboxmini").show(0);
	}
</script>

</body>
</html>

