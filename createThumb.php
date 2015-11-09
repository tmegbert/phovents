<?php

$imagePath = $argv[1];

    //Read original image and create Imagick object
    $image=new Imagick($imagePath);
    $thumbImage = clone $image;
    $midImage = clone $image;

    $d = $image->getImageGeometry(); 
    $w = $d['width']; 
    $h = $d['height'];

    $midH = 500;
    $midW = intval((500 / $h) * $w);
    $thumbH = 200;
    $thumbW = intval((200 / $h) * $w);

    //Scale the image
    $midImage->thumbnailImage($midW, $midH);
    $thumbImage->thumbnailImage($thumbW, $thumbH);

    //Write the new image to a file
    $midImage->writeImage('mid_image.jpg');
    $thumbImage->writeImage('thumb_image.jpg');
?>
