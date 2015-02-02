<?php

foreach ( glob ( "D:\\" ) as $files ) {
	echo "$files";
	$files1 = iconv ( 'GB2312', 'UTF-8', $files );
	$rsta = (is_readable ( $files ) ? '<font color=green>[√]读</font>' : '<font color=red>[×]读</font>');
// 	$wsta = (TestWrite ( $files ) ? '<font color=green>[√]写</font>' : '<font color=red>[×]写</font>');
	if (is_dir ( $files ))
		echo "<tr><td colspan='5'><font color=red>目录为:" . $files . $rsta ."</font></td></tr>";
	else
		echo "<tr><td>" . $files1 . $rsta . "</td><td>" . number_format ( ( float ) (filesize ( $files ) / 1024), 2 ) . "kb</td><td>" . date ( 'Y-m-d h:i:s', filemtime ( $files ) ) . "</td><td>" . fileperms ( $files ) . "</td><td>" . fileowner ( $files ) . "</td><tr>";
}
?>