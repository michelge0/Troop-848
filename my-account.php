<?php

require('helper/database-helper.php');
require('helper/authenticate.php');

$_SESSION['email'] = 'strengthofthepen@gmail.com';
$email = $_SESSION['email'];

if (isset($_POST['column'])) {
    $column = $_POST['column'];
    $value = $_POST['value'];

    $mysqli->query("UPDATE email_preferences SET $column=$value WHERE email='$email'");
}


$oncreate = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'")->fetch_assoc()['oncreate'];
$ondelete = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'")->fetch_assoc()['ondelete'];
$onedit = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'")->fetch_assoc()['onedit'];
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
</div>
</body>
</html>
