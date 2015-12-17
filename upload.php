<?php
/*******************************************************
 * upload.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

$phovent = $_POST['phovent'];
setcookie('phovent', $phovent);

$m = new MongoClient();
$db = $m->phovents;
$instance = $db->instances->findOne(array("name" => $phovent));

define('THUMB_HEIGHT', 200);
define('MID_HEIGHT', 640);
define('TARGET', $instance['path']);
define('FULL_DIR', $instance['path'] . '/fullsize/');
define('MID_DIR', $instance['path'] . '/midsize/');
define('THUMB_DIR', $instance['path'] . '/thumb/');

if(!file_exists(TARGET)){
    mkdir(TARGET);
    mkdir(FULL_DIR);
    mkdir(MID_DIR);
    mkdir(THUMB_DIR);
}


if(isset($_FILES)) {
    $index = 0;
    foreach($_FILES['fupload']['name'] as $filename){
     
        if(preg_match('/[.](jpg)|(jpeg)|(gif)|(png)$/i', $filename)) {
             
            if($instance != NULL){
                $l_filename = strtolower($filename);
                $source = $_FILES['fupload']['tmp_name'][$index];   
                $image = imagecreatefromstring(file_get_contents($source));
                $exif = exif_read_data($source);
                if(!empty($exif['Orientation'])) {
                    switch($exif['Orientation']) {
                        case 8:
                            $image = imagerotate($image,90,0);
                            break;
                        case 3:
                            $image = imagerotate($image,180,0);
                            break;
                        case 6:
                            $image = imagerotate($image,-90,0);
                            break;
                    }
                }
                $parts = pathinfo(FULL_DIR . $l_filename);
                $instance['pic_count']++;
                $t_filename = "pv_" . str_replace("'", "-", str_replace(" ", "_", strtolower($phovent))) . "_" . sprintf('%04d',$instance['pic_count']) . "." . $parts['extension'];
                $target = FULL_DIR . $t_filename;
                $db->instances->update(array("_id" => $instance['_id']), $instance);
                 
                move_uploaded_file($source, $target);
                 
                createSmallImages($image, $t_filename);     
                
            }
        }
        $index++;
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

function createSmallImages($image, $filename) 
{
    $jpg_file = pathinfo($filename, PATHINFO_FILENAME) . ".jpg";
     
    $ox = imagesx($image);
    $oy = imagesy($image);
     
    $nx = floor($ox * (THUMB_HEIGHT / $oy));
    $ny = THUMB_HEIGHT;
    $nm = imagecreatetruecolor($nx, $ny);
    imagecopyresized($nm, $image, 0,0,0,0,$nx,$ny,$ox,$oy);
    imagejpeg($nm, THUMB_DIR . $jpg_file);

    $nx = floor($ox * (MID_HEIGHT / $oy));
    $ny = MID_HEIGHT;
    $nm = imagecreatetruecolor($nx, $ny);
    imagecopyresized($nm, $image, 0,0,0,0,$nx,$ny,$ox,$oy);
    imagejpeg($nm, MID_DIR . $jpg_file);
}
?>
