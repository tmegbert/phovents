<?php
/*******************************************************
 * mgmt.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

    $error = "";
    $errors = array("The name for this phoVent has already been used.  Please try another.");

    $phoError = $_COOKIE['phoError'];
    if($phoError != NULL){
        $error = $errors[$phoError];
        setcookie('phoError', "");
    } 

    $fullName = "";
    $now = time();
    $m = new MongoClient();
    $db = $m->phovents;

    if($_POST){
        if($_POST['action'] == 'add'){
            $name = $_POST['name'];
            $instances = $db->instances->findOne(array("name" => $name));
            if(!empty($instances)){
                setcookie("phoError", 0);
                header("Location: http://www.nerkasoft.com/phovents/mgmt.php");
            } else {
                $owner = $_POST['owner'];
                $now = time();
                $expiration_date = strtotime($_POST['expire_date']);
                $newPhovent = array("name" => $name,
                                    "description" => $_POST['desc'],
                                    "path" => "/phovents/" . $name,
                                    "expiration_date" => $expiration_date,
                                    "creation_date" => $now,
                                    "owner" => $owner,
                                    "pic_count" => 0
                );

                $db->instances->insert($newPhovent); 

                $user = $db->users->findOne(array("email" => $owner));
                $fullName = $user['first_name'] . " " . $user['last_name'];
                $php_array = iterator_to_array($db->instances->find(array("owner" => $owner)));
                $phovents = array();
                foreach($php_array as $id => $data){
                   $phovents[$data['name']] = $data;
                } 
                $js_array = json_encode($phovents);
            }
        } else if($_POST['action'] == 'edit'){
            $owner = $_POST['owner'];
            $name = $_POST['name'];
            $phovent = $db->instances->findOne(array("name" => $name));
            $phovent['name'] = $name;
            $phovent['description'] = $_POST['desc'];
            $expiration_date = strtotime($_POST['expire_date']);
            $phovent['expiration_date'] = $expiration_date;
            $db->instances->update(array("_id" => $phovent['_id']), $phovent); 

            $user = $db->users->findOne(array("email" => $owner));
            $fullName = $user['first_name'] . " " . $user['last_name'];
            $php_array = iterator_to_array($db->instances->find(array("owner" => $owner)));
            $phovents = array();
            foreach($php_array as $id => $data){
               $phovents[$data['name']] = $data;
            } 
            $js_array = json_encode($phovents);
        } else if($_POST['action'] == 'delete'){
            $owner = $_POST['owner'];
            $db->instances->remove(array("name" => $_POST['name']));

            $user = $db->users->findOne(array("email" => $owner));
            $fullName = $user['first_name'] . " " . $user['last_name'];
            $php_array = iterator_to_array($db->instances->find(array("owner" => $owner)));
            $phovents = array();
            foreach($php_array as $id => $data){
               $phovents[$data['name']] = $data;
            } 
            $js_array = json_encode($phovents);
        } else {
            $salt = uniqid(mt_rand(), true);
            $owner = $_POST['email'];
            $password = $_POST['password'];
            $hash = hash('sha512', $password.$salt);
            $user = $db->users->findOne(array("email" => $owner));

            $savedHash = $user['hash'];
            $savedSalt = $user['salt'];
            $hashMatch = hash('sha512', $password.$savedSalt);
            if($hashMatch == $savedHash){
                $fullName = $user['first_name'] . " " . $user['last_name'];
                $php_array = iterator_to_array($db->instances->find(array("owner" => $owner)));
                $phovents = array();
                foreach($php_array as $id => $data){
                   $phovents[$data['name']] = $data;
                } 
                $js_array = json_encode($phovents);
                setcookie("phouser", $owner);
            } else {
                setcookie("phoError", 1);
                header("Location: http://www.nerkasoft.com/phovents");
            }
        }
    } else {
        $owner = $_COOKIE['phouser'];
        if(!empty($owner)){
            $user = $db->users->findOne(array("email" => $owner));
            $fullName = $user['first_name'] . " " . $user['last_name'];
            $php_array = iterator_to_array($db->instances->find(array("owner" => $owner)));
            $phovents = array();
            foreach($php_array as $id => $data){
               $phovents[$data['name']] = $data;
            } 
            $js_array = json_encode($phovents);
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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>phoVents</title>
    <script type="text/javascript">
        <? echo "var phovents = " . $js_array . ";\n"; ?>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
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
                    <button type="button" class="button_font" onClick="addCard()">Add a phoVent</button>
                </div>
                <form id="addForm" action="mgmt.php" method="POST">
                    <div>
                        <div id="light" class="white_content">
                            <div id="d_title">Edit</div>
                            <div class="clear inputline">
                                <div class="left">Phovent name</div>
                                <div class="right">
                                    <input type="text" name="name" id="name" class="inputbox"/>
                                </div>
                            </div>
                            <div class="clear inputline">
                                <div class="left">Description</div>
                                <div class="right">
                                    <input type="text" name="desc" id="desc" class="inputbox"/>
                                </div>
                            </div>
                            <div class="clear inputline">
                                <div class="left">Expiration date</div>
                                <div class="right">
                                    <input type="text" name="expire_date" id="datepicker" class="inputbox"/>
                                </div>
                            </div>
                            <div>
                                <div><button id="cancel_button" type="button" onClick="hideDialog()">Cancel</button></div>
                                <div><button id="save_button" type="submit" onClick="hideDialog()">Save</button></div>
                            </div>
                            <input id="cardAction" type="hidden" name="action" value="add"/>
                            <input type="hidden" name="owner" value="<?=$owner ?>"/>
                        </div>
                    </form>
                    <div id="fade" class="black_overlay"></div>
                </div>
            </div>
<?  if(!empty($error)):     ?>
                <div class="mg_error"><?= $error ?></div>
<?  endif;                  ?>   
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
