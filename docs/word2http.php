<?php 

function txt2http($fulldoc){
	$content = file_get_contents('D:\\1.txt');
	$str = str_replace("\n", "<br/>",str_replace("\r", "",$content));
	echo "<pre>";
	print_r($str);
}
function word2http(){
	$word = new COM("word.application") or die("无法定位WORD安装路径！");
	print "加载WORD（ 版本： {$word->Version} ）成功，已经保存在您的硬盘上了。\n";
	 
	//将其置前
	$word->Visible = 1;
	 
	//打开一个空文档
	$word->Documents->Add();
	 
	//随便做些事情
	$word->Selection->TypeText("这是一个在PHP中调用COM的测试。");
	//$word->;Selection->;TypeText("This is a test.。");
	$word->Documents[1]->SaveAs("test.doc");
	 
	 
	//关闭 word
	$word->Quit();
	 
	//释放对象
	$word->Release();
	$word = null;
}

word2http()
?>