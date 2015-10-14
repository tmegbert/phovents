<?php
/*******************************************************
 * gallery.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

//die(var_dump($phovent));
if($_POST['phoVent']){
    $phovent = $_POST['phoVent'];
    setcookie('phovent', $phovent);
} else if($_COOKIE['phovent']){
    $phovent = $_COOKIE['phovent'];
} else {
    $phovent = $_COOKIE['Arches'];
}

$m = new MongoClient();
$db = $m->phovents;
$exists = $db->instances->findOne(array("name" => $phovent));

if($exists == NULL){
    setcookie("phoError", 2);
    header("Location: http://www.nerkasoft.com/phovents");
} else {
    $thumbDir = $exists['path'] . "/thumb";
    $midsizeDir = $exists['path'] . "/midsize";
    $fullsizeDir = $exists['path'] . "/fullsize";
    $images = array_diff(scandir($fullsizeDir), array('..', '.'));

    $imageWidths = array();
    $index = 0;
    foreach($images as $image){
        $base = pathinfo($image, PATHINFO_FILENAME);
        $thumb = $thumbDir . "/" . $base . ".jpg";
        $mid = $midsizeDir . "/" . $base . ".jpg";
        $full = $fullsizeDir . "/" . $image;

        //Read original image and create Imagick object
        $imageD=new Imagick($thumb);
        $d = $imageD->getImageGeometry(); 
        $w = $d['width']; 
        $imageWidths[$index]['image'] = $full;
        $imageWidths[$index]['midsize'] = $mid;
        $imageWidths[$index]['thumb'] = $thumb;
        $imageWidths[$index]['name'] = $image;
        $imageWidths[$index]['width'] = $w;
        $index++;
    }
}

//die(var_dump($imageWidths));
?>
<html>
<head>
    <title>phoVents</title>
    <script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
    <script src="http://code.jquery.com/jquery-1.10.0.min.js"></script>
    <link rel="stylesheet" href="css/common.css" type="text/css">
    <link rel="stylesheet" href="css/gallery.css" type="text/css">
    <link rel="stylesheet" href="lightbox/lightbox.css" type="text/css" media="screen">
    <script type="text/javascript" src="lightbox/lightbox.js"></script>
    <script type="text/javascript">
        var jsArray = <? echo json_encode($imageWidths); ?>;
    </script>
    <script type="text/javascript" src="js/gallery.js"></script>
</head>
<body style="background-color:#333333">
    <script language="JavaScript" type="text/javascript"><!--
        s.pageName="Gallery"
        s.server="www.phovents.com"
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
        var s_code=s.t();if(s_code)document.write(s_code)//-->
    </script>
    <div id="blackBar">
        <div class="left home">
            <a href="signout.php">
                <img src="images/signout.png" alt="Home" height="50" width="50" />
            </a>
            <a href="mgmt.php">
                <img id="mg_icon" src="images/manage.png" alt="Home" height="50" width="50" />
            </a>
        </div>
        <div class="gallery_title">phoVent&nbsp;&nbsp;&nbsp;&nbsp;<?=$phovent?></div>
        <div id="add_photo">
            <form enctype="multipart/form-data" action="upload.php" method="post">
                <div id="add_photo-label">+ Add a photo</div>
                <input id="fileupload" type="file" name="fupload[]" multiple="multiple" />
                <input type="submit" value="Upload" />
                <input id="phovent" type="hidden" name="phovent" value="<?=$phovent?>">
            </form>
        </div>
    </div>
</body>
</html>
