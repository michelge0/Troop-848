<?php
require('init-session.php');

if ($_SESSION['signedIn'] != true) {
    header("Location: login.php");
    die();
}
?>
