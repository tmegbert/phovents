<?php

define('WIDTH', 300);

function createThumbnail($filename) 
{
    $info = pathinfo($filename);    
    $fullsizeDir = $info['dirname'];
    $thumbDir = str_replace("fullsize", "thumb", $fullsizeDir);
     
    if(preg_match('/[.](jpg)$/', $filename)) {
        $im = @imagecreatefromjpeg($fullsizeDir . $filename);
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
        $im = imagecreatefromgif($fullsizeDir . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng($fullsizeDir . $filename);
    }
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = WIDTH;
    $ny = floor($oy * (WIDTH / $ox));
     
    $nm = imagecreatetruecolor($nx, $ny);
     
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
     
    if(!file_exists($thumbDir)) {
      if(!mkdir($thumbDir)) {
           die("There was a problem. Please try again!");
      } 
       }
 
    imagejpeg($nm, $thumbDir . $filename);
    $tn .= 'Congratulations. Your thumbnail has been created.\n';
    echo $tn;
}

createThumbnail($argv[1]);     
?>
