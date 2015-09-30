<?php
/*******************************************************
 * thankyou.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

    $email = $_POST['email'];
    $m = new MongoClient();
    $db = $m->phovents;

    $contacts = array();
    $cursor = $db->contacts->find(array("email" => $email));
    foreach ($cursor as $doc) {
        $contacts[] = $doc['email'];
    }
    $today = date("F j, Y, g:i a");
    if(!empty($email) && !in_array($email, $contacts)){
        $db->contacts->insert(array("email" => $email, "date" => $today));
        $obj = $db->website->findOne();
        $obj['freeSpots'] -= 1;
        $db->website->update(array("_id" => $obj['_id']), $obj);
    }
?>
<html>
    <head>
        <script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
        <link rel="stylesheet" type="text/css" href="css/thankyou.css">
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
        
        <div id="thank_you"><img src="images/thankyou.png"/></div>
    </body>
</html>
