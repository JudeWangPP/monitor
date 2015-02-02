
<?php
if($_GET["type"]=="download"){
	$filedir=$_GET["filedir"];
	$value=explode('\\',$filedir);
	$filename = $value[count($value)-1];
	if(strpos($_SERVER["HTTP_USER_AGENT"],"Chrome")){
		$filedir = iconv('utf-8','gb2312',$filedir);
	}elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Firefox")){
		$filedir = iconv('utf-8','gb2312',$filedir);
	}elseif(strpos($_SERVER["HTTP_USER_AGENT"],"Safari")){
		$filedir = iconv('utf-8','gb2312',$filedir);
	}
	
	$ua = $_SERVER["HTTP_USER_AGENT"];
	if(is_file($filedir)) {
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=".$filename);
		ob_clean();
		flush();
		readfile($filedir);
		exit;
	}else{
		echo "{$filedir}文件不存在！";
		exit;
	}
}

?>