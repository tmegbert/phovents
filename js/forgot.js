function hideDialog()
{
    window.location="index.php";
}

window.onload = function() {
    document.getElementById('fade').style.display='block';
    document.getElementById('forgot_light').style.display='block';
    document.getElementById("response").focus();
};
