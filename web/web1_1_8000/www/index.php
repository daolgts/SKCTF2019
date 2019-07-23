<!DOCTYPE html>
<html>
<head>
   <title>WebSite</title>
   <link href="css/bootstrap.min.css" rel="stylesheet">
   <script src="js/jquery.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
   <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSite</a>
   </div>
   <div>
      <ul class="nav navbar-nav">
         <li class="active"><a href="index.php">Index</a></li>
         <li><a href="flag.php">Flag</a></li>
         </li>
      </ul>
   </div>
</nav>
<div class="span7 text-center">
<?php
   $act = '';
   if(!isset($_GET['act'])){
      print "<h1>Welcome To My WebSite!</h1>";
   }else{
      $act = $_GET['act'];
      switch ($act) {
         case 'news':
               echo "<h3><a href=http://www.chinanews.com/>新闻网</a></h3>";
               echo "<h3><a href=https://news.163.com/>网易新闻</a></h3>";
               echo "<h3><a href=https://news.sina.com.cn/>Sina</a></h3>";
            break;

         case 'photos':
               echo "<img src='img/1.jpg'>";
            break;
         default:
            echo "<h2>NOPE</h2>";
            break;
      }
   }
?>
</div>
</body>
</html>

