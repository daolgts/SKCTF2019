<?php
error_reporting(0);

function is_ok($c)
{
	if (preg_match('/[0-9a-zA-Z]{2}/',$c) === 1)
	{
		die("Get out of my site!");
	}
	return 1;
}

if (isset($_POST['p']) )
{
	$p = $_POST['p'];
	if (is_ok($p) === 1)
	{
		$pp = trim(base64_decode($p));
		@include($pp);
	}
	
}

highlight_file(__FILE__);

?>