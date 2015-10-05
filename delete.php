<?php
/*******************************************************
 * download.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

if($_COOKIE['phovent']){
    $phovent = $_COOKIE['phovent'];
} else {
    $phovent = "Arches";
}
 
$full_path = "/phovents/" . $phovent . "/fullsize/" . $_GET['delete_file']; 
$mid_path = "/phovents/" . $phovent . "/midsize/" . $_GET['delete_file']; 
$thumb_path = "/phovents/" . $phovent . "/thumb/" . $_GET['delete_file']; 

unlink($full_path);
unlink($mid_path);
unlink($thumb_path);

header('Location: gallery.php');
