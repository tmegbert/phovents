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
 
$m = new MongoClient();
$db = $m->phovents;
$instance = $db->instances->findOne(array("name" => $phovent));

$full_path = $instance['path'] . "/fullsize/" . $_GET['delete_file']; 
$mid_path = $instance['path'] . "/midsize/" . $_GET['delete_file']; 
$thumb_path = $instance['path'] . "/thumb/" . $_GET['delete_file']; 

unlink($full_path);
unlink($mid_path);
unlink($thumb_path);

header('Location: gallery.php');
