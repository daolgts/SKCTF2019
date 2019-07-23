<?php ob_start(); ?>
<?php
session_start();
//error_reporting(0);
header("Content-type: text/html;charset=utf-8");
define("UPLOAD_PATH","./upload");

if(@$_SESSION['logged']!=true )
{
        echo "<script>alert('Error！Please login first！');</script>";
        
        header('Location: index.php', true, 302);
        ob_end_flush();
        exit();
}

$is_upload = false;
$msg = null;
if (isset($_POST['submit'])) {
    if (file_exists(UPLOAD_PATH)) {
        $deny_ext = array("php","php5","php4","php3","php2","html","htm","phtml","pht","jsp","jspa","jspx","jsw","jsv","jspf","jtml","asp","aspx","asa","asax","ascx","ashx","asmx","cer","swf","htaccess");

        $file_name = trim($_FILES['upload_file']['name']);
        $file_name = str_ireplace($deny_ext,"", $file_name);
        $temp_file = $_FILES['upload_file']['tmp_name'];
        $img_path = UPLOAD_PATH.'/'.$file_name;        
        if (move_uploaded_file($temp_file, $img_path)) {
            $is_upload = true;
            echo "上传成功！";
        } else {
            $msg = '上传出错！';
        }
    } else {
        $msg = UPLOAD_PATH . '文件夹不存在,请手工创建！';
    }
}
?>

<div id="upload_panel">
        <h3>Upload area</h3>
        <form enctype="multipart/form-data" method="post">
            <p>Please select the file you want to upload:<p>
            <input class="input_file" type="file" name="upload_file"/>
            <input class="button" type="submit" name="submit" value="上传"/>
        </form>
        <div id="msg">
            <?php 
                if($msg != null){
                      echo "hint:".$msg;
                  }
             ?>
        </div>
</div>