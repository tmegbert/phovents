<?php
    $email = $_POST['email'];
    $m = new MongoClient();
    $db = $m->nerkasoft;
    $today = date("F j, Y, g:i a");
    if(!empty($email)){
        //$db->phovents->update(array("email" => $email, "date" => $today), array("email" => $email, "date" => $today), array("upsert" => true));
    }
?>
<html>
    <head>
        <script language="JavaScript" type="text/javascript" src="http://www.chalkogram.com/s_code.js"></script>
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <script type="text/javascript" src="//use.typekit.net/fnd7wzw.js"></script>
        <script type="text/javascript">
            try{Typekit.load();}catch(e){}
            
            //save freeSpots in Mongo
            localStorage.freeSpots -= 1;
        </script>
    </head>
    <body>
        <script language="JavaScript" type="text/javascript"><!--
            s.pageName="Thank You"
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
        
        <div id="thank_you">Thank you for your participation.<br>Your eMail address has been recorded.<br>We will contact you when the beta is ready.</div>
    </body>
</html>
