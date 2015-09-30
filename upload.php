<?php
$phovent = $_POST['phovent'];
setcookie('phovent', $phovent);

define('THUMB_WIDTH', 300);
define('MID_WIDTH', 640);
define('TARGET','images/magic/' . $phovent);
define('FULL_DIR','images/magic/' . $phovent . '/fullsize/');
define('MID_DIR','images/magic/' . $phovent . '/midsize/');
define('THUMB_DIR','images/magic/' . $phovent . '/thumb/');

if(!file_exists(TARGET)){
    mkdir(TARGET);
    mkdir(FULL_DIR);
    mkdir(MID_DIR);
    mkdir(THUMB_DIR);
}

function createSmallImages($filename) {
     
    if(preg_match('/[.](jpg)$/', $filename)) {
        $im = @imagecreatefromjpeg(FULL_DIR . $filename);
        if(!$im)
        {
            /* Create a black image */
            $im  = imagecreatetruecolor(150, 30);
            $bgc = imagecolorallocate($im, 255, 255, 255);
            $tc  = imagecolorallocate($im, 0, 0, 0);

            imagefilledrectangle($im, 0, 0, 150, 30, $bgc);

            /* Output an error message */
            imagestring($im, 1, 5, 5, 'Error loading ' . $imgname, $tc);
        }
    } else if (preg_match('/[.](gif)$/', $filename)) {
        $im = imagecreatefromgif(FULL_DIR . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng(FULL_DIR . $filename);
    }
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = THUMB_WIDTH;
    $ny = floor($oy * (THUMB_WIDTH / $ox));
    $nm = imagecreatetruecolor($nx, $ny);
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
    imagejpeg($nm, THUMB_DIR . $filename);

    $nx = MID_WIDTH;
    $ny = floor($oy * (MID_WIDTH / $ox));
    $nm = imagecreatetruecolor($nx, $ny);
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
    imagejpeg($nm, MID_DIR . $filename);
}

if(isset($_FILES['fupload'])) {
     
    if(preg_match('/[.](jpg)|(gif)|(png)$/i', $_FILES['fupload']['name'])) {
         
        $filename = $_FILES['fupload']['name'];
        $l_filename = strtolower($filename);
        $source = $_FILES['fupload']['tmp_name'];   
        $target = FULL_DIR . $l_filename;
         
        move_uploaded_file($source, $target);
         
        createSmallImages($l_filename);     
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
?>
