<?php

header('X-Frame-Options: SAMEORIGIN');//防止劫持
header('Server:testing only' );//
header( 'X-Powered-By:testing only' );

ini_set( 'session.cookie_httponly', 1 );

$db_host = "mysql";
$db_user = "root";
$db_password = "skctf2o19";
$db_name = "skctf2019";

$conn = mysqli_connect($db_host,$db_user,$db_password,$db_name);

// Check connection
if (mysqli_connect_errno())
{
echo "connection failed ->  " . mysqli_connect_error();
}

?>

