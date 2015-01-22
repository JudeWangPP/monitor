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
			<td><input id="ip" class="but" type="button" value="检查" maxlength="2"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td><div class="content">请选择类型</div></td>
		</tr>
	</table>



</body>
</html>

