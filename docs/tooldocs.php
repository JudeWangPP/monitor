<?php require_once 'config.php';?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport"
	content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
	<!--[if lt IE 9]>
	<script type="text/javascript" src="Lib/html5.js"></script>
	<![endif]-->
	<link href="static/h-ui/css/H-ui.css?v2013122601" rel="stylesheet" type="text/css" />
	<link href="static/h-ui/css/H-ui.doc.css?v2013122601" rel="stylesheet" type="text/css" />
	<link href="static/h-ui/css/H-ui.yun.css?v" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="Lib/jquery.min.js"></script>
	<script type="text/javascript" src="static/h-ui/js/H-ui.js?v2013122601"></script>
	<script type="text/javascript"
	src="static/h-ui/js/common.js?v2013122601"></script>
	<!--[if IE 6]>
	<script type="text/javascript" src="Lib/DD_belatedPNG_0.0.8a-min.js" ></script>
	<script>DD_belatedPNG.fix('.pngfix,.icon,.list-icon');</script>
	<![endif]-->
	<script type="text/javascript" src="Lib/stickUp.min.js"></script>
	<title>o(∩_∩)o</title>
</head>
<body>
<?php require_once 'header.php';?>
	<div class="cl frame-main">
		<?php require_once 'slider.php';?>
		<div class="dislpayArrow">
			<a ID = "wangzhipeng" class="pngfix" href="javascript:void(0);"></a>
		</div>
		<section class="Hui_article">
			<nav class="Hui_breadcrumb">
				<a class="maincolor" href="./">首页</a> 
				<span class="c_gray en">&gt;</span>
				<span class="c_gray">常用文档</span>
				<span class="c_gray en">&gt;</span>
				<span class="c_gray">工具说明文档</span>
			</nav>
<!-- 			开始正文内容			 -->
			<div class="Hui_articlebox">
				<article class="admin_con listview">
				<div class="dir-path cl pt-5 pb-5 pl-10 pr-10"><span class="l">全部文件</span><span class="r">已加载11个</span></div>
					<header class="cl">
						<div class="col c2">
							<span>修改时间</span>
						</div>
						<div class="col c3">
							<span>大小</span>
						</div>
						<div class="col c1">
							<span>文件名</span>
						</div>
					</header>
					<dl>
					<?php 
						$dir=TOOLDOCS;
						if(is_dir($dir)){
							$sh = opendir($dir);
							while (($file = readdir($sh)) != false){
								if (filetype($dir."\\".$file) == "dir"){
									//做dir 干的事情
								}else{
									echo "<dd class='item cl'>";
									$altertime=filemtime($dir."\\".$file);
									echo "<div class='col c2 c_gray' title='修改时间'><span>".date("Y-m-d H:i",$altertime)."</span></div>";
									$filesize=filesize($dir."\\".$file);
									$filesize=$filesize/1024/1024;
									$filesize=round($filesize,2);
									echo "<div class='col c3 c_gray' title='文件大小'><span>".$filesize."M</span></div>";
									$value=explode('.',$file);
									if ($value[count($value)-1] == 'docx'){
										$icontype='doc';
									}elseif($value[count($value)-1] == 'pptx' || $value[count($value)-1] == 'ppt' || $value[count($value)-1] == 'pps'){
										$icontype='other';
									}elseif($value[count($value)-1] == 'xlsx'){
										$icontype='xls';
									}elseif($value[count($value)-1] == 'vsd'){
										$icontype='v';
									}else{
										$icontype=$value[count($value)-1];
									}
									$filedir = $dir."\\".iconv('gb2312','utf-8',$file);
									echo "<div class='col c1'><span><i class='sprite-list-ic icon-".$icontype."'></i> <a href='".$filedir."' target='_blank'>".iconv('gb2312','utf-8',$file)."</a></span></div>";
									echo "<div class='listeditbar'><a href='man.php?type=download&filedir=".$filedir."' target='_blank' class='btn radius btn-small btn-success'>下载到本地</a></div>";
									echo "</dd>";
								}
							}
							closedir($sh);
						}
					?>
					</dl>
				</article>
			</div>
<!-- 			正文内容结束			 -->
		</section>
	</div>
	
<script> 
setTimeout("$('#wangzhipeng').trigger('click')",5000);
</script>
	
</body>
</html>