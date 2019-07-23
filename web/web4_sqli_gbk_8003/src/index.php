<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <!-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> -->
        <title>
            学生信息查询
        </title>
    </head>
    <body bgcolor="#000000">
        <div style=" margin-top:70px;color:#FFF; font-size:23px; text-align:center">
            请输入id查询
            <br>
            <font size="5" color="#00FF00">
<?php
header("Content-Type:text/html;charset=gbk");
function dbconnection() {
    @$con = mysql_connect("localhost", "root", "c2FkZmFnZGZkc3Nm");
    // Check connection
    if (!$con) {
        echo "Failed to connect to MySQL: " . mysql_error();
    }
    @mysql_select_db("sqli_gbk", $con) or die("Unable to connect to the database");
    // mysql_query("SET character set 'gbk'");
    
}
function check_addslashes($string) {
    $string = preg_replace('/' . preg_quote('\\') . '/', "\\\\\\", $string); //escape any backslash
    $string = preg_replace('/\'/i', '\\\'', $string); //escape single quote with a backslash
    $string = preg_replace('/\"/', "\\\"", $string); //escape double quote with a backslash
    return $string;
}
dbconnection();
// take the variables
if (isset($_GET['id'])) {
    $id = check_addslashes($_GET['id']);
    //echo "The filtered request is :" .$id . "<br>";
    //logging the connection parameters to a file for analysis.
    // $fp=fopen('result.txt','a');
    // fwrite($fp,'ID:'.$id."\n");
    // fclose($fp);
    // connectivity
    mysql_query("SET NAMES gbk");
    $sql = "SELECT * FROM users WHERE id='$id' LIMIT 0,1";
    $result = mysql_query($sql);
    $row = mysql_fetch_array($result);
    if ($row) {
        echo '<font color= "#00FF00">';
        echo '姓名：' . $row['name'];
        echo "<br>";
        echo '班级：' . $row['class'];
        echo "</font>";
    } else {
        echo '<font color= "#FFFF00">';
        print_r(mysql_error());
        echo "</font>";
    }
} else {
    echo "Please input the ID as parameter with numeric value";
}
?>

            </font>
        </div>
        </br>
        </br>
        </br>
        <center>
            </br>
            </br>
            </br>
            </br>
            </br>
            <font size='4' color="#33FFFF">
                <?php echo "Hint: The Query String you input is escaped as : ".$id .
                "<br>"; ?>
        </center>
        </font>
    </body>

</html>