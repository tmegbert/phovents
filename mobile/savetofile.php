<?php
$phoVent = strtolower($_POST['phoVent']);
if (isset($_FILES['myFile'])) {
    move_uploaded_file($_FILES['myFile']['tmp_name'], "/phovents/" . $phoVent . "/" . $_FILES['myFile']['name']);
    echo 'successful';
}
?>
