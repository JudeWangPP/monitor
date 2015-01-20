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
		echo "占用CPU前10的服务<br/>";
		$var = $opt->ssh2Exec($ip,$command);
		foreach ($var as $va){
			echo $va."<br/>";
			break;
		}
		echo "<br/><hr/>占用内存前10的服务<br/>";
		$var = $opt->ssh2Exec($ip,$command1);
		foreach ($var as $va){
			echo $va."<br/>";
			break;
		}
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="diy"){
	$ip=$_GET["ip"];
	echo "<iframe src='diy.php?ip=$ip' frameborder='0' width='100%' height='500px'></iframe>";

}
else if($_GET["type"]=="rm"){
	$ip=$_GET["ip"];
	$dir=$_GET["deldir"];
	if($dir == "/" || $dir == "/bin"|| $dir == "/sbin"){ //系统安全不能删除的目录
		echo "您删除的目录过于重要，请三思而行.";
	}else if($dir == ""){
		echo "表逗我，你要删啥？";
	}else if(!strstr($dir, '/')){
		echo "不好意思，这个目录我不认识啊！";
	}else if(substr($dir, -1) == "*"){
		echo "最后的*号不用输入，我会补全的!";
	}else{
		if (substr($dir, -1) != "/"){
			$dir=$dir."/";
		}
		$command = "rm -rf ".$dir."*";
		try{
			$opt=new SSH2Opt();
			$var = $opt->ssh2Exec($ip,$command);
			foreach ($var as $va){
				echo $va."<br/>";
			}
		}catch(PDOException $e){
			echo "在$ip上  执行删除 失败";
		}
	}
}

else if($_GET["type"]=="exec"){
	$ip=$_GET["ip"];
	$command=$_GET["execml"];
	if($command == "vim" || $command == "/bin"|| $command == "/sbin"){ //系统安全不能删除的目录
		echo "不能执行高级交互命令！";
	}else{
		try{
			$opt=new SSH2Opt();
			$var = $opt->ssh2Exec($ip,$command);
			foreach ($var as $va){
				echo $va."<br/>";
			}
		}catch(PDOException $e){
			echo "在$ip上  执行删除 失败";
		}
	}
}

?>
