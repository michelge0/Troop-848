<?php

require('init-session.php');

if (!$_SESSION['signedIn']) {
    header("Location: login.php");
    die();
}

?>
