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


if(isset($_FILES['fupload'])) {
     
    if(preg_match('/[.](jpg)|(gif)|(png)$/i', $_FILES['fupload']['name'])) {
         
        if($instance != NULL){
            $filename = $_FILES['fupload']['name'];
            $l_filename = strtolower($filename);
            $source = $_FILES['fupload']['tmp_name'];   
            $parts = pathinfo(FULL_DIR . $l_filename);
            $instance['pic_count']++;
            $t_filename = "pv_" . str_replace("'", "-", str_replace(" ", "_", strtolower($phovent))) . "_" . sprintf('%04d',$instance['pic_count']) . "." . $parts['extension'];
            $target = FULL_DIR . $t_filename;
            $db->instances->update(array("_id" => $instance['_id']), $instance);
             
            move_uploaded_file($source, $target);
             
            createSmallImages($t_filename);     
            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}

function createSmallImages($filename) {
     
    if(preg_match('/[.](jpg)$/', $filename)) {
        $im = @imagecreatefromjpeg(FULL_DIR . $filename);
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
        $im = imagecreatefromgif(FULL_DIR . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng(FULL_DIR . $filename);
    }
    
    $jpg_file = pathinfo($filename, PATHINFO_FILENAME) . ".jpg";
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = floor($ox * (THUMB_HEIGHT / $oy));
    $ny = THUMB_HEIGHT;
    $nm = imagecreatetruecolor($nx, $ny);
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
    imagejpeg($nm, THUMB_DIR . $jpg_file);

    $nx = floor($ox * (MID_HEIGHT / $oy));
    $ny = MID_HEIGHT;
    $nm = imagecreatetruecolor($nx, $ny);
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
    imagejpeg($nm, MID_DIR . $jpg_file);
}
?>
