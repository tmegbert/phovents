<?php

$orig = $argv[1];
$info = pathinfo($orig);    
$fullsizeDir = $info['dirname'];
$thumb = str_replace("fullsize", "thumb", $fullsizeDir) . "/" . $info['basename'];

//Read original image and create Imagick object
$image=new Imagick($orig);
$d = $image->getImageGeometry(); 
$w = $d['width']; 
$h = $d['height'];

$newH = 200;
$newW = intval((200 / $h) * $w);
//echo "width=" . $newW . "\n";
//echo "height=" . $newH . "\n";

//Scale the image
$image->thumbnailImage($newW, $newH);

//Write the new image to a file
$image->writeImage($thumb);

?>
