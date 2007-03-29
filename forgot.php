<?php
/*******************************************************
 * forgot.php
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
        "All registration fields are required"
    );

    $username = $_COOKIE['username'];
    $m = new MongoClient();
    $db = $m->phovents;

    $user = $db->users->findOne(array("username" => $username));
    $challenge = $user['challenge'];

    if(!empty($user)){
        $error = $errors[0];
    } else {
        //$db->users->update($user);
        $comment = "New account has been created";
    }
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
    <script type="text/javascript" src="js/forgot.js"></script>
</head>
 
<body>
    <script language="JavaScript" type="text/javascript"><!--
        s.pageName="Forgot"
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
<?php  if(!empty($error)):     ?>
                <div class="error"><?= $error ?></div>
<?php  endif;                  ?>   
<?php  if(!empty($comment)):     ?>
                <div class="comment"><?= $comment ?></div>
<?php  endif;                  ?>   
            </div>
            <div>
                <div id="forgot_light" class="forgot_content">
                    <form id="forgotForm" action="index.php" method="POST">
                        <div id="d_title">Reset password</div>
                        <div class="clear">
                            <div class="challenge_label">Challenge</div>
                            <div class="phrase"><?=$challenge?>&nbsp;</div>
                        </div>
                        <div class="clear">
                            <div class="label">Response</div>
                            <div class="reset_box"><input id="response" class="r_input input" type="text" name="response"/></div>
                        </div>
                        <div class="clear">
                            <div class="label">New password</div>
                            <div class="reset_box"><input id="new_pass" class="r_input input" type="password" name="password" onKeyPress="return searchKeyPress(event, 'forgot');" /></div>
                        </div>
                        <div class="clear">
                            <div><button id="forgot_cancel" class="forgot_cancel" type="button" onClick="hideDialog()">Cancel</button></div>
                            <div><button id="forgot_button" class="fbutton" type="button" onClick="document.forms['forgotForm'].submit()">Reset</button></div>
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
