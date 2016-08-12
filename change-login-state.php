<?php

// deprecated.

// if (isset($_POST['requestType'])) {

//     if ($_POST['requestType'] === "sign-in") {

//         $name = $_POST['name'];
//         $email = $_POST['email'];

//         require('database-helper.php');
//         require('init-session.php');

//         $result = $mysqli->query("SELECT * FROM roster WHERE email='$email'");
//         if ($result && $result->num_rows > 0) {
//             $_SESSION["signedIn"] = true;
//             $_SESSION["name"] = $name;

//             $permission_string = $result->fetch_all(MYSQLI_ASSOC)[0]['permissions'];
//             switch ($permission_string) {
//                 case "Editor": $_SESSION["permissions"] = 1; break;
//                 case "Admin": $_SESSION["permissions"] = 2; break;
//                 default: $_SESSION["permissions"] = 0;
//             }
//         }

//     } else if ($_POST['requestType' === "sign-out"]) {

//         $_SESSION["signedIn"] = false;
//         $_SESSION["name"] = "";
//         $_SESSION["permissions"] = 0;

//     }
//     die();
// }
?>