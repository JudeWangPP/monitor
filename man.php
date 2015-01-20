<?php
require_once "class.SSH2Opt.php";
if($_GET["type"]=="cpu"){
	$ip=$_GET["ip"];
	$command="cat /proc/cpuinfo";
	try{
		echo "基础信息：";
		echo "<table class='imagetable'>";
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$command);
		$strs = '';
		foreach ($var as $va){ //将数组 字符串化，用于做统计
			$strs = $strs.$va;
		}
		echo "<tr><td>物理CPU的个数</td><td>".substr_count($strs,'physical id')." 个</td></tr>";
		echo "<tr><td>逻辑CPU的个数</td><td>".substr_count($strs,'processor')." 个</td></tr>";
		$va = explode(':',$var[4]);
		echo "<tr><td>CPU型号</td><td>".$va[1]."</td></tr>";
		$va = explode(':',$var[6]);
		echo "<tr><td>CPU的主频</td><td>".$va[1]." MHz</td></tr>";
		$va = explode(':',$var[7]);
		echo "<tr><td>CPU的缓存</td><td>".$va[1]."</td></tr>";
		echo "</table>";
		
		echo "<br/>使用信息：";
		echo "<table class='imagetable'>";
		$var = $opt->ssh2Exec($ip,"mpstat");
		$value=explode(' ',$var[3]);
		echo "<tr><th>统计方式</th><th>".$value[3]."</th></tr>";
		echo "<tr><td>总使用率</td><td>".$value[7]."%</td></tr>";
		echo "<tr><td>系统使用</td><td>".$value[15]."%</td></tr>";
		echo "<tr><td>IO等待</td><td>".$value[19]."%</td></tr>";
		echo "<tr><td>软件使用</td><td>".$value[27]."%</td></tr>";
		echo "<tr><td>剩余</td><td>".$value[38]."%</td></tr>";
		echo "</table>";
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="memory"){
	$ip=$_GET["ip"];
	$command="free -m";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$command);
		
		$value=explode('    ',$var[1]);
		echo "<table class='imagetable'>";
		echo "<tr><th>内存总使用率</th><td>".round($value[3]/$value[2]*100,2)."%</td>";
		echo "</table><br/>";
		
		echo "<table class='imagetable'>";
		echo "<tr><th></th><th>内存总数</th><th>已使用</th><th>空闲内存</th><th>已经废弃</th><th>Buffer缓存内存数</th><th>Page缓存内存</th></tr>";
		echo "<tr><th>内存</th><td>".$value[2]."M</td><td>".$value[3]."M</td><td>".$value[5]."M</td><td>".$value[7]."M</td><td>".$value[9]."M</td><td>".$value[11]."M</td></tr>";
// 		$value=explode('    ',$var[2]);
// 		echo "<tr><th>缓存内存</th><td>".$value[1]."M</td><td>".$value[3]."M</td><td></td><td></td><td></td><td></td></tr>";
// 		$value=explode('    ',$var[3]);
// 		echo "<tr><th>".$value[0]."</th><td>".$value[2]."M</td><td>".$value[4]."M</td><td>".$value[5]."M</td><td></td><td></td><td></td></tr>";
		echo "</table>";

	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="disk"){
	$ip=$_GET["ip"];
	$command="df -l -m";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$command);
		echo "<table class='imagetable'>";
		echo "<tr><th>文件系统</th><th>总计（M）</th><th>已用（M）</th><th>可用（M）</th><th>已用（%）</th><th>挂载点</th></tr>";
		for ($i=1;$i<count($var);$i++){
			$value=explode(' ',$var[$i]);
			echo "<tr>";
			foreach($value as $val){
				if($val != ''){
					echo "<td>".$val."</td>";
				}
			}
			echo "</tr>";
		}
		echo "</table>";
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
		}
		echo "<br/><hr/>占用内存前10的服务<br/>";
		$var = $opt->ssh2Exec($ip,$command1);
		foreach ($var as $va){
			echo $va."<br/>";
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
	if(substr($command, -1) == ";"){
		$command = substr($command,0,strlen($command)-1);
	}
	$cmds=explode(';',$command); 
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Shell($ip,$cmds);
		echo "<pre>".$var."</pre>";
	}catch(PDOException $e){
		echo "在$ip上  执行删除 失败";
	}
}

?>
