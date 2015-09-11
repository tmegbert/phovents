function showDialog(type)
{
    document.getElementById('fade').style.display='block';
    if(type == 'login'){
        document.getElementById('signin_light').style.display='block';
        document.getElementById('register_light').style.display='none';
        document.getElementById('s_email').focus();
    } else {
        document.getElementById('signin_light').style.display='none';
        document.getElementById('register_light').style.display='block';
        document.getElementById('r_first').focus();
    }        
}

function hideLoginDialog()
{
    document.getElementById('signin_light').style.display='none';
    document.getElementById('fade').style.display='none';
}

function hideRegDialog()
{
    document.getElementById('register_light').style.display='none';
    document.getElementById('fade').style.display='none';
}

function searchKeyPress(e, dialog)
{
    e = e || window.event;
    if (e.keyCode == 13){
        if (dialog == 'login'){
            document.forms['signinForm'].submit();
        } else {
            document.forms['registerForm'].submit();
        }
        return false;
    }
    return true;
}
