
<html>
<head>
    <meta charset="UTF-8">
    <title>一个不能按的按钮</title>
    <link href="http://libs.baidu.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body{
            margin-left:auto;
            margin-right:auto;
            margin-TOP:200PX;
            width:20em;
        }
    </style>
</head>
<body>
<h3>一个不能按的按钮</h3>

<form action="" method="get" >
<input  disabled class="btn btn-default" style="height:50px;width:200px;" type="submit" value="flag" name="file" />
</form>
</body>
</html>


<?php
error_reporting(0);
if (isset($_GET['file'])) {
	if($_GET['file'] === "flag"){
		highlight_file("flag.php");
	}else{
		$page = $_GET['file'];
	}
} else {
	$page = "./flag.php";
}

assert("file_exists('$page')");




?>

