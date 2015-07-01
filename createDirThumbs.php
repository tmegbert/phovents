<?php

$orig = $argv[1];
$fullsizeDir = $orig . "/fullsize";
$images = array_diff(scandir($fullsizeDir), array('..', '.'));
foreach($images as $image){
    $full = $fullsizeDir . "/" . $image;    
    $thumb = $orig . "/thumb/" . $image;

    //Read original image and create Imagick object
    $image=new Imagick($full);
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
}
?>
