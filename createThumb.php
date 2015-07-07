<?php

$imagePath = $argv[1];

    //Read original image and create Imagick object
    $image=new Imagick($imagePath);
    $d = $image->getImageGeometry(); 
    $w = $d['width']; 
    $h = $d['height'];

    $newH = 500;
    $newW = intval((500 / $h) * $w);
    //echo "width=" . $newW . "\n";
    //echo "height=" . $newH . "\n";

    //Scale the image
    $image->thumbnailImage($newW, $newH);

    //Write the new image to a file
    $image->writeImage('test_image.jpg');
?>
