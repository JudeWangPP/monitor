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
</head>
<body>
	<input id="ip" type="text" value="<?php echo $ip;?>" maxlength="15" style="display: none">
	<table>
		<tr>
			<td>删除指定目录下的所有文件:</td>
			<td><input id="ip" type="text" value="/home/tester" maxlength="30"></td>
			<td><input id="ip" type="button" value="删除" maxlength="30"></td>
		</tr>
		<tr height = "60">
			<td align = "right">执行常用简单的Linux命令:</td>
			<td><input id="ip" type="text" value="/home/tester" maxlength="30"></td>
			<td><input id="ip" type="button" value="执行" maxlength="30"></td>
		</tr>
	</table>
	<div>执行结果:</div>
	<div style="width:100%;height:100%;border:1px solid #082E54">1</div>
</body>
</html>

