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
        window.onload=function(){
            document.getElementById("sign-ups-left").innerHTML = "Premium sign-ups still available: " + <?= $obj['freeSpots'] ?>;
        }

        function validateForm()
        {
            var terms_checkbox = document.getElementById('terms_check');
            var email_input = document.getElementById('email');
            if(!terms_checkbox.checked){
                alert('You must accept the "Terms of Use" to sign-up');
                return false;
            }
            if(!email_input.value){
                alert('eMail address is required to sign up');
                return false;
            }
        }
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

    <div class="center">
        <img src="images/phovents_logo.png"/>
    </div>
    <div id="content">
        <div id="left_container">
            <div>
                <div class="left_cartoon">Problem</div>
                <div><img src="images/problem.jpg"></img></div>
            </div>
            <div id="sol_div">
                <div class="left_cartoon">Solution</div>
                <div><img src="images/solution.jpg"></img></div>
            </div>
        </div>
        <div id="right_container">
            <div>
                <p>
                    We are currently developing software to solve this problem.  phoVents.com will enable 
                    all event participants to easily and immediately share their photos
                    for the event.<br><br>  When phoVents is complete, it will include a mobile app for your
                    phone that will allow you to send photos you have taken to phoVents.com.
                    Simply share the phoVent name with all those at the event and they will
                    be able to upload or download the event photos.<br><br>
                    Because we are at the very beginning of development for this project, we are offering free premium
                    service for life for the first 100 people to sign up.  If you are interested in this project
                    and would like to participate in the beta version when ready, please sign up below.
                </p>
            </div>
            <div id="sign-ups-left"></div>
            <div>
                <div>
                    <form id="beta_form" name="beta_form" action="thankyou.php" method="post">
                        <div>Email:&nbsp;&nbsp;<input id="email" type="email" name="email" size="50">
                            <input id="submit" type="submit" value="Sign up now!" onClick="return validateForm()"></div>
                        <div id="terms"><input id="terms_check" type="checkbox" name="terms_check" value="Terms">I have read and accept the <a href="tou.html" target="_blank">Terms of Use.</a></div>
                    </form>
                </div>
                <h2 id="sample_heading">Sample phoVents</h2>
                <div>
                    <div class="left_button button">
                        <form action="gallery.php" method="POST">
                            <input type="image" name="phoVent" value="Powell" src="images/lake_powell-button.jpg" /> 
                        </form>
                    </div>
                    <div class="button">
                        <form action="gallery.php" method="POST">
                            <input type="image" name="phoVent" value="Arches" src="images/arches-button.jpg" /> 
                        </form>
                    </div>
                </div>
                <div>
                    <div class="left_button button">
                        <form action="gallery.php" method="POST">
                            <input type="image" name="phoVent" value="Zion" src="images/zion-button.jpg" /> 
                        </form>
                    </div>
                    <div class="button">
                        <form action="gallery.php" method="POST">
                            <input type="image" name="phoVent" value="Clouds" src="images/cloud-button.jpg" /> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer id="footer">
        <div>
            <span id="left"></span>
            <span id="copyright">Copyright 2015 Nerkasoft</span>
            <span><a id="privacy" target="_blank" href="privacypolicy.html">Privacy Policy</a></span>
        </div>
    </footer>
</body>
</html>
