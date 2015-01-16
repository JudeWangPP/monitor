<?php
require_once "class.SSH2Opt.php";
if($_GET["type"]=="cpu"){
	$ip=$_GET["ip"];
	$command="cat /proc/cpuinfo";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$command);
		foreach ($var as $va){
			echo $va."<br/>";
		}
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="memory"){
	$ip=$_GET["ip"];
	$command="free";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$command);
		foreach ($var as $va){
			echo $va."<br/>";
		}
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="disk"){
	$ip=$_GET["ip"];
	$command="df -l";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$command);
		foreach ($var as $va){
			echo $va."<br/>";
		}
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="service"){
	$ip=$_GET["ip"];
	$command="ps aux|head -1;ps aux|grep -v PID|sort -rn -k +3|head";
	$command1="ps aux|head -1;ps aux|grep -v PID|sort -rn -k +4|head";
	try{
		$opt=new SSH2Opt();
		echo "占用CPU前10的服务<hr/>";
		$var = $opt->ssh2Exec($ip,$command);
		foreach ($var as $va){
// 			echo $va."<br/>";
		}
		echo "占用内存前10的服务<hr/>";
		$var = $opt->ssh2Exec($ip,$command1);
		foreach ($var as $va){
			echo $va."<br/>";
		}
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="diy"){
	echo "<iframe src='diy.php' frameborder='0' width='100%' height='500px'></iframe>";

}

else if($_GET["action"]=="select"){
	$rule="";
	if(isset($_POST["channel_number"])&&$_POST["channel_number"]!="")
		$rule.=" and c.channel_number like '%{$_POST["channel_number"]}%' ";
	if(isset($_POST["channel_name"])&&$_POST["channel_name"]!="")
		$rule.=" and c.channel_name like '%{$_POST["channel_name"]}%' ";
	if(isset($_POST["bd"])&&$_POST["bd"]!="")
		$rule.=" and c.bd like '%{$_POST["bd"]}%' ";
	if(isset($_POST["promotion_team"])&&$_POST["promotion_team"]!="")
		$rule.=" and c.promotion_number= '{$_POST["promotion_team"]}'";
	if(isset($_POST["payment_method"])&&$_POST["payment_method"]!="")
		$rule.=" and c.payment_number='{$_POST["payment_method"]}' ";
	if(isset($_POST["cooperation_mode"])&&$_POST["cooperation_mode"]!="")
		$rule.=" and c.cooperation_number= '{$_POST["cooperation_mode"]}'";
	if(isset($_POST["version_type"])&&$_POST["version_type"]!="")
		$rule.=" and c.version_number= '{$_POST["version_type"]}'";
	if(isset($_POST["has_sdk"])&&$_POST["has_sdk"]!="")
		$rule.=" and c.has_sdk= '{$_POST["has_sdk"]}'";
	
	$db=new ChannelDB();
	$rows=$db->selectChannelNumbers($rule);
	$datas = array();
	$data = array();
	foreach($rows as $row){
		for($i=1;$i<7;$i++){ 
			$data[$i-1]=$row[$i];
		}
		$data[6]="<a class='btn btn-default btn-sm btn-icon icon-left' href='update.php?id={$row[0]}'><i class='entypo-pencil'></i><b>修改</b></a>";
		array_push($datas,$data);
	}
	echo json_encode($datas);
}
?>
