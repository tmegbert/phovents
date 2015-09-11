<?php
    $error = "";
    $fullName = "";
    $now = time();
    if($_POST){
        $m = new MongoClient();
        $db = $m->phovents;

        $salt = uniqid(mt_rand(), true);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $hash = hash('sha512', $password.$salt);
        $user = $db->users->findOne(array("email" => $email));

        $savedHash = $user['hash'];
        $savedSalt = $user['salt'];
        $hashMatch = hash('sha512', $password.$savedSalt);
        if($hashMatch == $savedHash){
            $fullName = $user['first_name'] . " " . $user['last_name'];
            $php_array = iterator_to_array($db->instances->find(array("owner" => $email)));
            $phovents = array();
            foreach($php_array as $id => $data){
               $phovents[$data['name']] = $data;
            } 
            $js_array = json_encode($phovents);
        } else {
            setcookie("phoError", 1);
            header("Location: http://www.nerkasoft.com/phovents");
        }
    }
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 
<head>
    <link rel="icon" href="./favicon.ico">
    <script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="stylesheet" type="text/css" href="css/mgmt.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>phoVents</title>
    <script type="text/javascript">
        <? echo "var phovents = " . $js_array . ";\n"; ?>
    </script>
    <script type="text/javascript" src="js/mgmt.js"></script>
</head>
 
<body>
    <script language="JavaScript" type="text/javascript"><!--
        s.pageName="Management"
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

    <div class="signin_div">
        <div class="signin_name"><?=$fullName?></div>
        <div class="signin_button"><a id="signin_txt" onClick="signOut()">Sign out</a></div>
    </div>

    <span id="mgmt">
        <center>
            <div id="logo">
                <img src="images/phovents_logo_small.png"/>
            </div>
            <div id="content">
                <div id="addPhovent_div">
                    <button type="button" class="button_font" onClick="addCard()">Add phoVent</button>
                </div>
                <div>
                    <div id="light" class="white_content">
                        <div id="d_title"></div>
                        <div class="inputline">
                            <div class="left">Phovent name</div>
                            <div class="right"><input type="text" id="name" class="inputbox"/></div>
                        </div>
                        <div class="clear inputline">
                            <div class="left">Description</div>
                            <div class="right"><input type="text" id="desc" class="inputbox"/></div>
                        </div>
                        <div class="clear inputline">
                            <div class="left">Creation date</div>
                            <div class="right"><input type="text" id="creation_date" class="inputbox"/></div>
                        </div>
                        <div class="clear inputline">
                            <div class="left">Expiration date</div>
                            <div class="right"><input type="text" id="expiration_date" class="inputbox"/></div>
                        </div>
                        <div>
                            <div><button id="cancel_button" type="button" onClick="hideDialog('cancel')">Cancel</button></div>
                            <div><button id="save_button" type="button" onClick="hideDialog('save')">Save</button></div>
                        </div>
                    </div>
                    <div id="fade" class="black_overlay"></div>
                </div>
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
