<?php
$phovent = $_POST['phoVent'];
$thumbDir = "images/magic/" . $phovent . "/thumb";
$images = array_diff(scandir($thumbDir), array('..', '.'));

?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 
<head>
    <link rel="stylesheet" type="text/css" href="css/gallery.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>gallery</title>
</head>
    <body>
<?php 
    foreach($images as $image){
        echo '<div>';
        echo '    <img src="' . $thumbDir . '/' . $image . '">';
        echo '</div>';
    }
?>
    </body>
</html>
