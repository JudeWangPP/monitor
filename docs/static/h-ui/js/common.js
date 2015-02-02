// JavaScript Document
$(function(){
	$("#nav-toggle").click(function(){
		$(".Hui_aside").slideToggle();		
	});	
	
	$(".dislpayArrow a").click(function(){
		if($(".Hui_aside").is(":hidden")){
			$(".Hui_aside").show();$(this).removeClass("open");
			$(".Hui_article,.dislpayArrow").css({"left":"200px"});
		}else{
			$(this).addClass("open");
			$(".Hui_aside").hide();
			$(".Hui_article,.dislpayArrow").css({"left":"0"});
		}
	});
	
	$.Huitab("#websafecolor .colortab span","#websafecolor .colorcon","selected","click","0");
	$.Huitab("#tab_demo .tabBar span","#tab_demo .tabCon","Current","click","0");
	$.Huitab("#tab_demo2 .tabBar span","#tab_demo2 .tabCon","Current","mousemove","1");
	$.Huitab("#bgpic .colortab span","#bgpic .colorcon","selected","click","0");

	/*鏂扮獥鍙ｆ煡鐪嬩唬鐮�*/
	$.Huihover('.codeView');
}); 