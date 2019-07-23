
<?php
 error_reporting(0);
 echo "Please input the file parameter";
 if($_GET['file']) {
$file = $_GET['file'];
include ($file);
}
else{
include('index.php');
}
?>