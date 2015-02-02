
<aside class="Hui_aside">
	<div class="menu_dropdown bk_2">
		<dl id="menu_1">
			<dt>
				常用文档<b></b>
			</dt>
			<dd>
				<ul>
					<li><a href="tooldocs.php">工具说明文档</a></li>
					<li><a href="#">项目相关资料</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu_2">
			<dt>
				项目相关资料<b></b>
			</dt>
			<dd>
				<ul>
					<li><a href="#">产品</a></li>
					<li><a href="#">直连</a></li>
					<li><a href="#">订单</a></li>
					<li><a href="#">国际酒店</a></li>
					<li><a href="#">其他</a></li>
				</ul>
			</dd>
		</dl>
		<dl id="menu_3">
			<dt>
				技术相关资料<b></b>
			</dt>
			<dd>
				<ul>
					<li><a href="#">PHP</a></li>
					<li><a href="#">.NET</a></li>
					<li><a href="#">JAVA</a></li>
					<li><a href="#">数据库</a></li>
					<li><a href="#">LINUX</a></li>
				</ul>
			</dd>
		</dl>
	</div>
	<script type="text/javascript">
	$(function(){
		var webSite2 ="。/";
		var loc=location.href;var url2 = loc.replace(webSite2,"");
		$(".menu_dropdown ul li").each(function(){var current = $(this).find("a");$(this).removeClass("current");if(url2 == $(current[0]).attr("href")){$(this).addClass("current");}});
	});

    function uiVisible(){
       
    	var url=window.location.href.split("/");
		var pname=url[url.length-1];
		for(var i=0;i<$("a").length;i++){
			if($($("a")[i]).attr("href")==pname){
				$($("a")[i]).parents("li").addClass("current");
				$($("a")[i]).parents("dl").addClass("selected");
			}
		}
	};
	uiVisible();
	</script>
</aside>