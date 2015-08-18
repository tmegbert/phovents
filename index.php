<?php
    $m = new MongoClient();
    $db = $m->phovents;
    $obj = $db->website->findOne();
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 
<head>
    <link rel="icon" href="./favicon.ico">
    <script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>phoVents</title>
    <script type="text/javascript">
    </script>
</head>
 
<body>
    <script language="JavaScript" type="text/javascript"><!--
        s.pageName="Main"
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

    <div id="signin_div">
        <a id="signin_txt" href="signin.php">Sign in</a>
    </div>

    <span id="main">
        <center>
            <div id="logo">
                <img src="images/phovents_logo.png"/>
            </div>
            <div id="content">
                <div id="name_div">phoVent</div>
                <div id="in_div">
                    <form action="gallery.php" method="POST">
                        <input class="input" type="text" name="phoVent"/> 
                        <input class="submit" type="submit" name="Go" value="Go" /> 
                    </form>
                </div>
                <div id="samples">Samples available: Powell, Zion, Clouds, Arches</div>
            </div>
        </center>
    </span>
    
    <footer id="footer">
        <div>
            <span id="left"></span>
            <span id="copyright">Copyright 2015 Nerkasoft</span>
            <span><a id="privacy" target="_blank" href="privacypolicy.html">Privacy Policy</a></span>
        </div>
    </footer>
</body>
</html>
