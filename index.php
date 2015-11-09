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
        "User not authorized for this phoVent",
        "All registration fields are required",
        "Challenge response incorrect, password not reset"
    );

    $phoError = $_COOKIE['phoError'];
    if($_COOKIE['phoError']){
        $error = $errors[$_COOKIE["phoError"]];
        setcookie('phoError', "");
    } 

    $fullName = "";
    $now = time();
    if($_POST){
        $response = $_POST['response'];
        if(!empty($response)){  //password reset
            $m = new MongoClient();
            $db = $m->phovents;
            $username = $_COOKIE['username'];
            $user = $db->users->findOne(array("username" => $username));
            $r_hash = hash('sha512', $response.$user['salt']);
            if($r_hash == $user['a_hash']){
                $p_hash = hash('sha512', $_POST['password'] . $user['salt']);
                $user['hash'] = $p_hash;
                $db->users->update(array("_id" => $user['_id']), $user);
                $comment = "Password has been reset";
            } else {
                $error = $errors[4];
            }
        } elseif(
            empty($_POST['firstname']) ||
            empty($_POST['lastname']) ||
            empty($_POST['email']) ||
            empty($_POST['challenge']) ||
            empty($_POST['answer']) ||
            empty($_POST['username']) ||
            empty($_POST['password'])){ 
                $error = $errors[3];
        } else {
            $m = new MongoClient();
            $db = $m->phovents;

            $salt = uniqid(mt_rand(), true);
            $username = $_POST['username'];
            $password = $_POST['password'];
            $answer = $_POST['answer'];
            $form = $_POST['form'];
            $hash = hash('sha512', $password.$salt);
            $a_hash = hash('sha512', $answer.$salt);
            $user = $db->users->findOne(array("username" => $username));

            if(!empty($user)){
                $error = $errors[0];
            } else {
                $userObj = array("first_name" => $_POST['firstname'],
                        "last_name" => $_POST['lastname'],
                        "email" => $_POST['email'],
                        "challenge" => $_POST['challenge'],
                        "a_hash" => $a_hash,
                        "username" => $username,
                        "hash" => $hash,
                        "last_login" => $now,
                        "creation_time" => $now,
                        "salt" => $salt
                );
                $db->users->insert($userObj);
                $comment = "New account has been created";
            }
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
                <img src="images/phovents_logo_beta.png"/>
            </div>
            <div id="content">
                <form id="phoForm" action="gallery.php" method="POST">
                    <div id="name_div">phoVent</div>
                    <div id="in_div">
                        <input id="phoVent" class="p_input input" type="text" name="phoVent"/> 
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
                            <div class="label">Username</div>
                            <div class="input_box"><input id="s_username" class="s_input input" type="text" name="username"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">Password</div>
                            <div class="input_box"><input id="s_pass" class="s_input input" type="password" name="password" onKeyPress="return searchKeyPress(event, 'login');" /></div>
                        </div>
                        <div class="clear">
                            <div></div>
                            <div class="forgot_desc" onClick="showDialog('forgot')">Forgot password?  Enter username and click here</div>
                        </div>
                        <div class="clear">
                            <div><button id="signin_cancel" class="cancel_button" type="button" onClick="hideDialog('login')">Cancel</button></div>
                            <div><button id="signin_button" class="sbutton" type="button" onClick="document.forms['signinForm'].submit()">Sign in</button></div>
                        </div>
                    </form>
                </div>
                <div id="register_light" class="register_content">
                    <form id="registerForm" action="" method="POST">
                        <div id="d_title">Register</div>
                        <div class="clear">
                            <div class="label">First name</div>
                            <div class="input_box"><input id="r_first" class="r_input input" type="text" name="firstname"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">Last name</div>
                            <div class="input_box"><input id="r_last" class="r_input input" type="text" name="lastname"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">Email address</div>
                            <div class="input_box"><input id="r_email" class="r_input input" type="text" name="email"/></div>
                        </div>
                        <div class="clear">
                            <div class="challenge_label">Challenge</div>
                            <div class="input_box_desc"><input id="r_challenge" class="r_input input" type="text" name="challenge"/></div>
                        </div>
                        <div class="clear">
                            <div></div>
                            <div class="chall_desc">Phrase or question used for password change verification</div>
                        </div>
                        <div class="clear">
                            <div class="challenge_label">Response</div>
                            <div class="input_box_desc"><input id="r_answer" class="r_input input" type="text" name="answer"/></div>
                        </div>
                        <div class="clear">
                            <div></div>
                            <div class="resp_desc">Response to the challenge phrase or question</div>
                        </div>
                        <div class="clear">
                            <div class="label">Username</div>
                            <div class="input_box"><input id="r_username" class="r_input input" type="text" name="username"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">Password</div>
                            <div class="input_box"><input id="r_pass" class="r_input input" type="password" name="password" onKeyPress="return searchKeyPress(event, 'register');" /></div>
                        </div>
                        <div class="clear">
                            <div><button id="reg_cancel" class="cancel_button" type="button" onClick="hideDialog('reg')">Cancel</button></div>
                            <div><button id="reg_button" type="button" onClick="document.forms['registerForm'].submit()">Register</button></div>
                        </div>
                    </form>
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
