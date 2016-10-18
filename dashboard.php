<?php

require('helper/database-helper.php');
require('helper/authenticate.php');

// EMAIL PREFERENCES

$email = $_SESSION['email'];

if (isset($_POST['column'])) {
    $column = $_POST['column'];
    $value = $_POST['value'];

    $mysqli->query("UPDATE email_preferences SET $column=$value WHERE email='$email'");
}

$oncreate = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'")->fetch_assoc()['oncreate'];
$ondelete = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'")->fetch_assoc()['ondelete'];
$onedit = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'")->fetch_assoc()['onedit'];

// SENDING EMAILS

if (isset($_POST['sendMail'])) {
    require('helper/mail.php');

    $to = "";
    if ($_POST['sendMail'] === "patrol") $to = get_patrol_emails($email);
    else if ($_POST['sendMail'] === "troop") $to = get_all_emails($email);

    $subject = $_POST['subject'];
    $text = $_POST['message'];
    $html = "<p>$text</p>";
    send_mail($to, $subject, $text, $html);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="google-signin-client_id" content="251137415595-uttj6cdrkgfahoc0hffe2je2gt29utbo.apps.googleusercontent.com">
<?php require('helper/imports.php'); ?>

    <!-- bootstrap toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(document).ready(function() {
            // detect changes
            $(':checkbox').change(function() {

                var id = this.getAttribute('id');
                var checked = this.checked ? 1 : 0;
                
                $.ajax({
                    data: {column: id, value: checked},
                    type: "POST",
                    dataType: "text",
                });
            });
        }); 
    </script>
</head>

<body>

<?php include('header.php') ?>

<div class="content">
    <div class="checkbox">
        Email me when events are created:
        <?php if ($oncreate) : ?>
        <input type="checkbox" value="true" id="oncreate" data-toggle="toggle" data-on="Yes" data-off="No" checked>
        <?php else : ?>
        <input type="checkbox" value="true" id="oncreate" data-toggle="toggle" data-on="Yes" data-off="No">
        <?php endif; ?>
    </div>

    <div class="checkbox">
        Email me when events are cancelled:
        <?php if ($ondelete) : ?>
        <input type="checkbox" value="true" id="ondelete" data-toggle="toggle" data-on="Yes" data-off="No" checked>
        <?php else : ?>
        <input type="checkbox" value="true" id="ondelete" data-toggle="toggle" data-on="Yes" data-off="No">
        <?php endif; ?>
    </div>

    <div class="checkbox">
        Email me when events are rescheduled/changed:
        <?php if ($onedit) : ?>
        <input type="checkbox" value="true" id="onedit" data-toggle="toggle" data-on="Yes" data-off="No" checked>
        <?php else : ?>
        <input type="checkbox" value="true" id="onedit" data-toggle="toggle" data-on="Yes" data-off="No">
        <?php endif; ?>
    </div>

    <div class="dashboard-form">
        <h3> Email My Patrol </h3>
        <form method="POST">
            <input type="hidden" name="sendMail" value="patrol">
            <div class="form-group">
                <label>Subject: </label>
                <input type="text" class="form-control" name="subject">
            </div>
            <div class="form-group">
                <label>Message: </label>
                <textarea class="form-control" rows="10" name="message"></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Send">
        </form>
    </div>

    <!-- Editors / Admins only -->
    <?php if ($_SESSION["permissions"] >= 1) : ?>
    <div class="dashboard-form">
        <h3> Email Entire Troop </h3>
        <form method="POST">
            <input type="hidden" name="sendMail" value="troop">
            <div class="form-group">
                <label>Subject: </label>
                <input type="text" class="form-control" name="subject">
            </div>
            <div class="form-group">
                <label>Message: </label>
                <textarea class="form-control" rows="10" name="message"></textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Send">
        </form>
    </div>
    <?php endif; ?>

<?php
    $id = $_SESSION["id"];
    $user = $mysqli->query("SELECT * FROM roster WHERE id=$id")->fetch_assoc();
?>  
<div class="dashboard-form">
    <h3> Edit Personal Information </h3>
    <p> Below you can edit the information that will be available to the whole troop on the roster page. All information is protected and cannot be viewed by anyone outside the troop. When you're done making changes, hit "Submit Edits" to save your changes. </p>

    <form id="changeForm" action="maintenance/update-roster.php?type=edit" method="POST">
        <div class="form-group">
            <label for="userName">Name:</label> 
            <input type="text" class="form-control" id="userName" name="name" value=<?php echo "\"".$user['name']."\"";?>>
        </div>
        <div class="form-group">
            <label for="userEmail">Email (emails will be sent to this address):</label>
            <input type="text" class="form-control" id="userEmail" name="email" value=<?php echo "\"".$user['email']."\"";?>>
        </div>
        <div class="form-group">
            <label for="userLoginEmail">Login Email (email you use for logging in--must be Gmail):</label>
            <input type="text" class="form-control" id="userLoginEmail" name="loginEmail" value=<?php echo "\"".$user['login_email']."\"";?>>
        </div>
        <div class="form-group">
            <label for="userEmail">Address:</label>
            <input type="text" class="form-control" id="userAddress" name="address" value=<?php echo "\"".$user['address']."\"";?>>
        </div>
        <div class="form-group">
            <label for="userEmail">Phone:</label>
            <input type="text" class="form-control" id="userPhone" name="phone" value=<?php echo "\"".$user['phone']."\"";?>>
        </div>
        <input type="hidden" name="patrol" value=<?php echo "\"".$user['patrol']."\"";?>>
        <input type="hidden" name="permissions" value=<?php echo "\"".$user['permissions']."\"";?>>
        <input type="submit" class="btn btn-primary" value="Submit Edits">
    </form>
</div>

</div>
</body>
</html>
