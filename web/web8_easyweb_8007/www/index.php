<?php ob_start(); ?>
<?php
session_start();

include('connect.php');

    if(@$_SESSION['logged']!=true)
    {
	    $_SESSION['logged']='';

    }

   if($_SESSION['logged']==true &&  $_SESSION['admin']!='')
    {

	    echo "you are logged in :)";
	    header('Location: upload.php', true, 302);
        ob_end_flush();
    }

    else {
    echo

        '<div align=center style="margin:30px 0px 0px 0px;">
        <font size=8 face="comic sans ms">
        --==[[ SKCTF-2019 easyweb]]==--</font> <br><br>
        Talk is cheap! Show me your SQLI skills! <br>
    
        <form method=post>
        Username :- <Input type=text name=user> &nbsp Password:- <Input type=password name=pass> <br><br>
        <input type=submit name=login value="let\'s login">';

    }

    if(isset($_POST['login'])) {

        $uname=str_replace('\'','',urldecode($_POST['user']));
        $pass=str_replace('\'','',urldecode($_POST['pass']));

        $sql='select * from skctf2019_admin where  password=\''.$pass.'\' and username=\''.$uname.'\'';

	    $result = mysqli_query($conn, $sql);

	    //账号密码正确登陆
	    if (mysqli_num_rows($result) > 0) {
	      $row = mysqli_fetch_assoc($result);
	   	    echo "You are allowed!<br>";
	      $_SESSION['logged']=true;
	      $_SESSION['admin']=$row['username'];

	     header('Location: upload.php', true, 302);
	     ob_end_flush();
	    }
    else
        echo "<script>alert('Error! Try again. There may be gains elsewhere!');</script>";
    }

?>

