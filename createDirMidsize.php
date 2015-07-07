<?php

$orig = $argv[1];
$fullsizeDir = $orig . "/fullsize";
$images = array_diff(scandir($fullsizeDir), array('..', '.'));
foreach($images as $image){
    $full = $fullsizeDir . "/" . $image;    
    $midsize = $orig . "/midsize/" . $image;

    //Read original image and create Imagick object
    $image=new Imagick($full);
    $d = $image->getImageGeometry(); 
    $w = $d['width']; 
    $h = $d['height'];

    $newH = 500;
    $newW = intval(($newH / $h) * $w);
    //echo "width=" . $newW . "\n";
    //echo "height=" . $newH . "\n";

    //Scale the image
    $image->thumbnailImage($newW, $newH);

    //Write the new image to a file
    $image->writeImage($midsize);
}
?>
