<?php
/*******************************************************
 * createDirImages.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

$orig = $argv[1];
$fullsizeDir = $orig . "/fullsize";
$images = array_diff(scandir($fullsizeDir), array('..', '.'));
foreach($images as $image){
    $full = $fullsizeDir . "/" . $image;    
    $thumb = $orig . "/thumb/" . $image;
    $midsize = $orig . "/midsize/" . $image;

    //Read original image and create Imagick object
    $image=new Imagick($full);
    $thumbImage = clone $image;    
    $midImage = clone $image;    

    $d = $image->getImageGeometry(); 
    $w = $d['width']; 
    $h = $d['height'];

    $thumbH = 200;
    $thumbW = intval((200 / $h) * $w);
    $midH = 500;
    $midW = intval((500 / $h) * $w);

    //Scale the image
    $thumbImage->thumbnailImage($thumbW, $thumbH);
    $thumbImage->writeImage($thumb);

    $midImage->thumbnailImage($midW, $midH);
    $midImage->writeImage($midsize);
}
?>
