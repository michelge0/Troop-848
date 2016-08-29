<?php
    // if this is an ajax request called from the same page, via onSuccess()
    // purpose is to verify that the user that logged in is on the roster

    if (isset($_POST['name'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];

        require('helper/database-helper.php');
        require('helper/init-session.php');

        $result = $mysqli->query("SELECT * FROM roster WHERE login_email='$email'");
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $_SESSION["signedIn"] = true;
            $_SESSION["name"] = $name;
            $_SESSION["email"] = $row['email'];
            $_SESSION["id"] = $row['id'];

            $permission_string = $row['permissions'];
            switch ($permission_string) {
                case "Editor": $_SESSION["permissions"] = 1; break;
                case "Admin": $_SESSION["permissions"] = 2; break;
                default: $_SESSION["permissions"] = 0;
            }

            echo "authorized";
        } else {
            require('helper/logout.php');
        }

        die();
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="google-signin-client_id" content="251137415595-uttj6cdrkgfahoc0hffe2je2gt29utbo.apps.googleusercontent.com">
<title>Troop 848</title>
    <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>

    <script src="scripts/logout.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    <script>
    function renderButton() {
        gapi.signin2.render('my-signin2', {
            'scope': 'profile email',
            'width': 225,
            'height': 80,
            'theme': 'dark',
            'longtile': true,
            'onsuccess': onSuccess,
            'onfailure': onFailure
        });
    }
    function onSuccess(googleUser) {
        var prof = googleUser.getBasicProfile();

        $.ajax({
            data: {name: prof.getName(), email: prof.getEmail()},
            type: "POST",
            dataType: "text",
            success: function(msg) {
                if (msg == "authorized") {
                    window.location = "index.php";
                } else {
                    alert("Email isn't recognized. Please contact [person] to get this fixed. If you need to sign in with another account, sign out of this one first.");
                    gapi.load('auth2', function() {
                        auth2 = gapi.auth2.getAuthInstance();
                        auth2.signOut();
                    });
                }
            },
            error: function() {
                alert("There was an error in the code. If this keeps happening, please report it to the webmaster.");
            }
        });
    }

    function onFailure(error) {
        alert("Sign-in unsuccessful :(");
    }

    </script>

    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/landing.css" />
</head>

<body>
<div class="title">TROOP <strong>848</strong></div>
<div class="footer">
	<div class="description">For over 25 years, Troop 848 has been serving the Chesterfield, Missouri region. We have over 200 Eagle Scouts and are a great troop.</div>
	<div id="my-signin2" class="button-secondary" data-redirecturi="http://localhost:9999"></div>
	<div class="button-main">Join Us</div>
</div>
</body>
</html>
