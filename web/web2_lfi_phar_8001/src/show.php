<?php  
@$imageid = $_GET['imageid'];
if(empty($imageid))
{
	echo "<br>请输入imageid";
}
else
{
	echo <<<EOF
	<div class="alert alert-success" role="alert">
	图像上传成功,<a href="uploads/$imageid.png" class="alert-link">点此查看</a>
	</div>
EOF;
}

?>
