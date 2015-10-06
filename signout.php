<?php
/*******************************************************
 * signout.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

setcookie("phouser", "", time()-3600);
header('Location: index.php');
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 
<head>
    <link rel="icon" href="./favicon.ico">
    <script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
    <link rel="stylesheet" type="text/css" href="css/signin.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>Sign out</title>
    <script type="text/javascript">
    </script>
</head>
 
<body>
    <script language="JavaScript" type="text/javascript"><!--
        s.pageName="Sign out"
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
</body>
</html>
