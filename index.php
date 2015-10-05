<?php
/*******************************************************
 * index.php
 *
 * @author      Tarrence Egbert
 * @copyright   2015 Adobe Systems Inc.
 *
 ******************************************************/

session_start();

    $error = "";
    $errors = array("This account is already in use, please try another",
        "Username or password was incorrect, please try other credentials",
        "User not authorized for this phoVent"
    );

    $phoError = $_COOKIE['phoError'];
    if($_COOKIE['phoError']){
        $error = $errors[$_COOKIE["phoError"]];
        setcookie('phoError', "");
    } 

    $fullName = "";
    $now = time();
    if($_POST){
        $m = new MongoClient();
        $db = $m->phovents;

        $salt = uniqid(mt_rand(), true);
        $email = $_POST['email'];
        $password = $_POST['password'];
        $form = $_POST['form'];
        $hash = hash('sha512', $password.$salt);
        $user = $db->users->findOne(array("email" => $email));

        if(!empty($user)){
            $error = $errors[0];
        } else {
            $userObj = array("first_name" => $_POST['firstname'],
                    "last_name" => $_POST['lastname'],
                    "email" => $email,
                    "hash" => $hash,
                    "last_login" => $now,
                    "creation_time" => $now,
                    "salt" => $salt
            );
            $db->users->insert($userObj);
            $comment = "New account has been created";
        }
    }
    //$obj = $db->website->findOne();
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 
<head>
    <link rel="icon" href="./favicon.ico">
    <script language="JavaScript" type="text/javascript" src="js/s_code.js"></script>
    <link rel="stylesheet" type="text/css" href="css/common.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <meta name="author" content="" />
    <title>phoVents</title>
    <script type="text/javascript" src="js/main.js"></script>
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

    <div class="signin_div">
        <div class="signin_button">
            <a id="signin_txt" onClick="showDialog('login')">Sign in</a>
        </div>
    </div>

    <span id="main">
        <center>
            <div id="logo">
                <img src="images/phovents_logo.png"/>
            </div>
            <div id="content">
                <form id="phoForm" action="gallery.php" method="POST">
                    <div id="name_div">phoVent</div>
                    <div id="in_div">
                        <input id="phoVent" class="input" type="text" name="phoVent"/> 
                    </div>
                    <div id="mgb_div">
                        <button class="gbutton" type="button" onClick="document.forms['phoForm'].submit()">Go</button> 
                    </div>
                </form>
                <div id="samples">Samples available: Powell, Zion, Clouds, Arches</div>
                <div id="reg_info">
                    <div>If you would like to create phoVents to share with your friends:</div>
                    <div>
                        <div><button id="register_button" type="button" onClick="showDialog('register')">Register for premium account</button></div>
                    </div>
                </div>
<?  if(!empty($error)):     ?>
                <div class="error"><?= $error ?></div>
<?  endif;                  ?>   
<?  if(!empty($comment)):     ?>
                <div class="comment"><?= $comment ?></div>
<?  endif;                  ?>   
            </div>
            <div>
                <div id="signin_light" class="signin_content">
                    <form id="signinForm" action="mgmt.php" method="POST">
                        <div id="d_title">Sign-in</div>
                        <div class="clear">
                            <div class="label">e-Mail</div>
                            <div class="input_box"><input id="s_email" class="input" type="text" name="email"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">Password</div>
                            <div class="input_box"><input id="s_pass" class="input" type="password" name="password" onKeyPress="return searchKeyPress(event, 'login');" /></div>
                        </div>
                        <div class="clear">
                            <div><button id="cancel_button" type="button" onClick="hideLoginDialog()">Cancel</button></div>
                            <div><button id="signin_button" class="sbutton" type="button" onClick="document.forms['signinForm'].submit()">Sign in</button></div>
                        </div>
                    </form>
                </div>
                <div id="register_light" class="register_content">
                    <form id="registerForm" action="" method="POST">
                        <div>
                            <div class="label">First name</div>
                            <div class="input_box"><input id="r_first" class="input" type="text" name="firstname"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">Last name</div>
                            <div class="input_box"><input id="r_last" class="input" type="text" name="lastname"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">e-Mail</div>
                            <div class="input_box"><input id="r_email" class="input" type="text" name="email"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">passWord</div>
                            <div class="input_box"><input id="r_pass" class="input" type="password" name="password" onKeyPress="return searchKeyPress(event, 'register');" /></div>
                        </div>
                        <div class="clear">
                            <div><button id="cancel_button" type="button" onClick="hideRegDialog()">Cancel</button></div>
                            <div><button id="reg_button" class="gbutton" type="button" onClick="document.forms['registerForm'].submit()">Register</button></div>
                        </div>
                    </form>
                </div>
                </div>
                <div id="fade" class="black_overlay"></div>
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
