<?php
include('flag.php');
function welcome($arr)
{
	$data = "I am looking at you %s";
	foreach ($arr as $_k => $_v) {
		$data = sprintf($data,$_v);
	}
	echo $data;
}

$arr = array($_GET['myname'],$flag);

echo welcome($arr).'<br>';

highlight_file(__FILE__);