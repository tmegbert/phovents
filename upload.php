<?php

define('WIDTH', 300);
define('PATH_FULL','images/fullsized/');
define('PATH_THUMB','images/thumbs/');

function createThumbnail($filename) {
     
    if(preg_match('/[.](jpg)$/', $filename)) {
        $im = @imagecreatefromjpeg(PATH_FULL . $filename);
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
        $im = imagecreatefromgif(PATH_FULL . $filename);
    } else if (preg_match('/[.](png)$/', $filename)) {
        $im = imagecreatefrompng(PATH_FULL . $filename);
    }
     
    $ox = imagesx($im);
    $oy = imagesy($im);
     
    $nx = WIDTH;
    $ny = floor($oy * (WIDTH / $ox));
     
    $nm = imagecreatetruecolor($nx, $ny);
     
    imagecopyresized($nm, $im, 0,0,0,0,$nx,$ny,$ox,$oy);
     
    if(!file_exists(PATH_THUMB)) {
      if(!mkdir(PATH_THUMB)) {
           die("There was a problem. Please try again!");
      } 
       }
 
    imagejpeg($nm, PATH_THUMB . $filename);
    $tn = '<img src="' . PATH_THUMB . $filename . '" alt="image" />';
    $tn .= '<br />Congratulations. Your file has been successfully uploaded, and a      thumbnail has been created.';
    echo $tn;
}

if(isset($_FILES['fupload'])) {
     
    //if( preg_match('/\.(jpg|jpeg|png|gif)(?:[\?\#].*)?$/i', $_FILES['fupload']['name'] ){
    if(preg_match('/[.](jpg)|(gif)|(png)$/i', $_FILES['fupload']['name'])) {
         
        $filename = $_FILES['fupload']['name'];
        $l_filename = strtolower($filename);
        $source = $_FILES['fupload']['tmp_name'];   
        $target = PATH_FULL . $l_filename;
         
        move_uploaded_file($source, $target);
         
        createThumbnail($l_filename);     
    }
}
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 
<head>
    <script language="JavaScript" type="text/javascript" src="http://www.phovents.com/js/VisitorAPI.js"></script>
    <script language="JavaScript" type="text/javascript" src="http://www.phovents.com/js/AppMeasurement.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>Dynamic Thumbnails</title>
</head>
 
    <body>
    <script language="JavaScript" type="text/javascript"><!--
    /* You may give each page an identifying name, server, and channel on
    the next lines. */
    s.pageName="Upload"
    s.server=""
    s.channel=""
    s.pageType=""
    s.prop1=""
    s.prop2=""
    s.prop3=""
    s.prop4=""
    s.prop5=""
    /* Conversion Variables */
    s.campaign=""
    s.state=""
    s.zip=""
    s.events=""
    s.products=""
    s.purchaseID=""
    s.eVar1=""
    s.eVar2=""
    s.eVar3=""
    s.eVar4=""
    s.eVar5=""
    var s_code=s.t();if(s_code)document.write(s_code)//--></script>

    <h1>Upload A File, Man!</h1>
    <form enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF'] ?>" method="post">
        <input type="file" name="fupload" />
        <input type="submit" value="Go!" />
    </form>
    <div
      class="fb-like"
      data-share="true"
      data-width="450"
      data-show-faces="true">
    </div>
</body>
</html>
