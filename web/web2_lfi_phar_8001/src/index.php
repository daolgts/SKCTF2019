<?php
error_reporting(0);

@session_start();
// posix_setuid(1000);

$f = empty($_GET['f']) ? 'fail' : $_GET['f'];
if(preg_match('/\.\./',$f))
{
	die('Be a good student!');
}
if(preg_match('/rm/i',$_SERVER["QUERY_STRING"]))
{
	die();
}

foreach ($_POST as $key => $value) {
	if(preg_match('/rm/i',$value))
	{
		die();
	}
	if(preg_match('/mv/i',$value))
	{
		die();
	}
	if(preg_match('/cp/i',$value))
	{
		die();
	}
	if(preg_match('/touch/i',$value))
	{
		die();
	}
	if(preg_match('/>/i',$value))
	{
		die();
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>图像系统</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div class="container">
			<div class="jumbotron">
				<h1>图片存储</h1>
				<p class="lead">请在这里上传您的图片,我们将为您保存:)</p>
				<form action="?f=upload" method="POST" id="form" enctype="multipart/form-data">
					<input type="file" id="image" name="image" class="btn btn-lg btn-success" style="margin-left: auto; margin-right: auto;">
					<input type="submit" id="submit" name="submit" class="btn btn-lg btn-success" role="button" value="上传图片">
				</form>
			</div>
	   	</div>
	</body>
</html>
<?php
if($f !== 'fail')
{
	if(!(include($f.'.php')))
	{
		?>
		<div class="alert alert-danger" role="alert">NOPE</div>
		<?php
			exit;
	}
}
?>
