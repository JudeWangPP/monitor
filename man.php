<?php
require_once "class.SSH2Opt.php";
require_once 'classDBOpt.php';
if($_GET["type"]=="cpu"){
	$ip=$_GET["ip"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$command="cat /proc/cpuinfo";
	try{
		echo "基础信息：";
		echo "<table class='imagetable'>";
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$user,$pass,$command);
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
		$var = $opt->ssh2Exec($ip,$user,$pass,"mpstat");
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
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$command="free -m";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$user,$pass,$command);
		$value=explode('    ',$var[2]);
		echo "<table class='imagetable'>";
		echo "<tr><th>内存使用率</th><td>".round($value[1]/($value[1]+$value[3])*100,2)."%</td>";
		echo "</table><br/>";
		
// 		echo "<table class='imagetable'>";
// 		echo "<tr><th></th><th>内存总数</th><th>已使用</th><th>空闲内存</th><th>已经废弃</th><th>Buffer缓存内存数</th><th>Page缓存内存</th></tr>";
// 		echo "<tr><th>内存</th><td>".$value[2]."M</td><td>".$value[3]."M</td><td>".$value[5]."M</td><td>".$value[7]."M</td><td>".$value[9]."M</td><td>".$value[11]."M</td></tr>";
// 		$value=explode('    ',$var[2]);
// 		echo "<tr><th>缓存内存</th><td>".$value[1]."M</td><td>".$value[3]."M</td><td></td><td></td><td></td><td></td></tr>";
// 		$value=explode('    ',$var[3]);
// 		echo "<tr><th>".$value[0]."</th><td>".$value[2]."M</td><td>".$value[4]."M</td><td>".$value[5]."M</td><td></td><td></td><td></td></tr>";
// 		echo "</table>";
		
		echo "<table class='imagetable'>";
		echo "<tr><th></th><th>内存总数（M）</th><th>已使用（M）</th><th>空闲内存（M）</th><th>已经废弃（M）</th><th>Buffer缓存内存数（M）</th><th>Page缓存内存（M）</th></tr>";
		//我也不知道这个for循环该这么备注了 ，总之就是为了获取期望的table。
		for ($i=1;$i<count($var);$i++){
			$value=explode(' ',$var[$i]);
			echo "<tr>";
			if ($i == 2){
				$num = 1;
				foreach($value as $val){
					if($val != '' && $val != '-/+'){
						if($num == 2){
							echo "<td></td>";
						}
						echo "<td>".$val."</td>";
						$num++;
					}
				}
			}else{
				foreach($value as $val){
					if($val != '' && $val != '-/+'){
						echo "<td>".$val."</td>";
					}
				}
			}
			echo "</tr>";
		}
		echo "</table>";
		echo <<<EOF
<pre>说明：

Mem开头的行：
内存总数：比如这台机器4G内存，实际上已经扣除掉了作为显存的部分。
已使用　：这部分既包括操作系统本身使用的部分，也包括应用程序已经使用的部分，还包括缓存的部分。
空闲内存：操作系统还没有使用的内存数。我们通常看到这部分比较小。
已经废弃：已经废弃不用，总是显示0。
Buffer缓存内存：作为缓存的内存数
Page缓存内存：作为缓存的内存数

-/+ buffers/cache开头的行：（重点看这行）
已使用　：应用程序总共使用的内存数。等于Mem.used-Mem.buffers-Mem.cached。
空闲内存：是指应用程序还未使用的内存数。这个数据才是我们需要关注的空闲可用内存数。等于Mem.free+Mem.buffers+Mem.cached。
如果此行中free列的数据太小，那么就需要优化程序或者增加物理内存了。
				
Swap开头的行：为交换分区，在物理内存不够时，才进行Swap交换
				
详情请参考：Linux free -m 命令详解

EOF;

	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="disk"){
	$ip=$_GET["ip"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$command="df -l -m";
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Exec($ip,$user,$pass,$command);
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
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$command="ps aux|head -1;ps aux|grep -v PID|sort -rn -k +3|head";
	$command1="ps aux|head -1;ps aux|grep -v PID|sort -rn -k +4|head";
	try{
		$opt=new SSH2Opt();
		echo "占用CPU前10的服务<br/>";
		$var = $opt->ssh2Exec($ip,$user,$pass,$command);
		echo "<table class='imagetable'>";
		echo "<tr><th>用户</th><th>PID</th><th>CPU使用率（%）</th><th>内存使用率（%）</th><th>占用虚拟内存（KB）</th><th>占用物理内存（KB）</th><th>进程状态</th><th>开始运行时间</th><th>占用CPU时间</th><th>启动进程命令</th><th>操作</th></tr>";
		for ($i=1;$i<count($var);$i++){
			$value=explode(' ',$var[$i]);
			echo "<tr>";
			$num = 1;
			$allComm="";
			foreach($value as $val){
				if($val != '' && $val != '?' && $num < 10){
					echo "<td>".$val."</td>";
					$num++;
				}else{
					if ($num > 9){
						$allComm=$allComm.$val.'&nbsp';
					}
				}

			}
			echo "<td title=$allComm>".substr($allComm,0,40)."</td>";
			echo "<td><input type='button' value = 'kill' class='but' onclick='kill();'></td>";
			echo "</tr>";
		}
		echo "</table>";
		echo "<br/>占用内存前10的服务<br/>";
		$var = $opt->ssh2Exec($ip,$user,$pass,$command1);
		echo "<table class='imagetable'>";
		echo "<tr><th>用户</th><th>PID</th><th>CPU使用率（%）</th><th>内存使用率（%）</th><th>占用虚拟内存（KB）</th><th>占用物理内存（KB）</th><th>进程状态</th><th>开始运行时间</th><th>占用CPU时间</th><th>启动进程命令</th><th>操作</th></tr>";
		for ($i=1;$i<count($var);$i++){
			$value=explode(' ',$var[$i]);
			echo "<tr>";
			$num = 1;
			$allComm="";
			foreach($value as $val){
				if($val != '' && $val != '?' && $num < 10){
					echo "<td>".$val."</td>";
					$num++;
				}else{
					if ($num > 9){
						$allComm=$allComm.$val.'&nbsp';
					}
				}

			}
			echo "<td title=$allComm>".substr($allComm,0,40)."</td>";
			echo "<td><input type='button' value = 'kill' class='but' onclick='kill();'></td>";
			echo "</tr>";
		}
		echo "</table>";
	}catch(PDOException $e){
		echo "查询 $ip 失败";
	}

}
else if($_GET["type"]=="diy"){
	$ip=$_GET["ip"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	echo "<iframe src='diy.php?ip=$ip&user=$user&pass=$pass' frameborder='0' width='100%' height='450px'></iframe>";

}
else if($_GET["type"]=="rm"){
	$ip=$_GET["ip"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
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
			$var = $opt->ssh2Exec($ip,$user,$pass,$command);
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
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$command=$_GET["execml"];
	if(substr($command, -1) == ";"){
		$command = substr($command,0,strlen($command)-1);
	}
	$cmds=explode(';',$command); 
	try{
		$opt=new SSH2Opt();
		$var = $opt->ssh2Shell($ip,$user,$pass,$cmds);
		echo "<pre>".$var."</pre>";
	}catch(PDOException $e){
		echo "在$ip上  执行删除 失败";
	}
}
////////////////////////////////////////////////////////下边是mysql主从同步请求接收
else if($_GET["type"]=="mands"){
	$ip="192.168.".$_GET["group"].".16";
	$port=$_GET["port"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$sql="show slave status;";
	try{
		$opt=new classDBOpt();
		$vars = $opt->execSql($ip,$port,$user,$pass,$sql);
		if(count($vars) == 0){
			echo 0;
		}else{
			echo "<table class='imagetable'>";
			echo "<tr><th width='30%'>项目</th><th width='50%'>值</th><th width='20%'>说明/操作</th>";
			foreach ($vars as $var){
				echo"<tr><th>主从当前状态</th><td>".$var['Slave_IO_State']."</td></tr>";
				echo"<tr><th>主机IP地址</th><td>".$var['Master_Host']."</td></tr>";
				echo"<tr><th>主机端口</th><td>".$var['Master_Port']."</td></tr>";
				if($var['Seconds_Behind_Master'] == 0){
					echo"<tr><th>主从同步延时秒数</th><td style='font-size:18px;color:green'>".$var['Seconds_Behind_Master']."</td></tr>";
				}else{
					echo"<tr><th>主从同步延时秒数</th><td  style='font-size:18px;color:red;'>".$var['Seconds_Behind_Master']."(延迟)</td></tr>";
				}
				if($var['Slave_IO_Running'] == 'Yes'){
					echo"<tr><th>Slave_IO_Running</th><td style='font-size:18px;color:green'>".$var['Slave_IO_Running']."</td></tr>";
				}else{
					echo"<tr><th>Slave_IO_Running</th><td style='font-size:18px;color:red;'>".$var['Slave_IO_Running']."<td>IO挂掉了<br/>请联系管理员处理</td></td></tr>";
					echo"<tr><th>最后一次IO错误</th><td >".$var['Last_IO_Error']."</td></tr>";
				}
				if($var['Slave_SQL_Running'] == 'Yes'){
					echo"<tr><th>Slave_SQL_Running</th><td style='font-size:18px;color:green'>".$var['Slave_SQL_Running']."</td></tr>";
				}else{
					echo"<tr><th>Slave_SQL_Running</th><td style='font-size:18px;color:red;'>".$var['Slave_SQL_Running']."<td><input id='fix' class='but' type='button' onclick='fixSlaveSqlStatus()' value='修复'></td></td></tr>";
					echo"<tr><th>最后一次SQL错误</th><td>".$var['Last_SQL_Error']."</td></tr>";
				}

			}
		}
		echo "</table>";
		echo "<pre>说明：
Slave_IO_Running 和 Slave_SQL_Running 均为 Yes 的时候说明主从同步服务正常运行。
主从同步延时秒数 为0时，说明同步及时
当Slave_SQL_Running 状态为 No的时候，说明/操作 列会 出现“修复”按钮，点击进行修复。
开启自动刷新后，每隔5s刷新一次，如想停止请刷新页面。</pre>";
		echo "<input id='allSlaveStatus' class='but' style='background-color:#cccccc;' type='button' onclick='allSlaveStatus()' value='查看全部主从同步信息'>";
	}catch(PDOException $e){
		echo "在$ip上  执行删除 失败";
	}
}
else if($_GET["type"]=="fix"){
	$ip="192.168.".$_GET["group"].".16";
	$port=$_GET["port"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$sql1="SLAVE STOP;";
	$sql2="SET GLOBAL sql_slave_skip_counter = 1;";
	$sql3=" SLAVE START;";
	try{
		$opt=new classDBOpt();
		$vars1 = $opt->execSql($ip,$port,$user,$pass,$sql);
		$vars2 = $opt->execSql($ip,$port,$user,$pass,$sql);
		$vars3 = $opt->execSql($ip,$port,$user,$pass,$sql);
		echo $vars1,$vars2,$vars3;
	}catch(PDOException $e){
		echo "在$ip上  执行删除 失败";
	}
}
else if($_GET["type"]=="allmands"){
	$ip="192.168.".$_GET["group"].".16";
	$port=$_GET["port"];
	$user=$_GET["user"];
	$pass=$_GET["pass"];
	$sql="show slave status;";
	try{
		$opt=new classDBOpt();
		$vars = $opt->execSql($ip,$port,$user,$pass,$sql);
		echo "<table class='imagetable'>";
		echo "<tr><th>项目</th><th>值</th>";
		$flag=0;
		foreach ($vars[0] as $key=>$a){
			if($flag%2 == 1){
				$flag++;
				continue;
			}
			echo"<tr><th>".$key."</th><td>".$a."</td></tr>";
			$flag++;
		}
		echo "</table>";
// 		print_r($vars[0]);
	}catch(PDOException $e){
		echo "在$ip上  执行删除 失败";
	}
}
?>
