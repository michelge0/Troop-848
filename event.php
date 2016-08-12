<?php
session_start();
require('database-helper.php');

if (isset($_GET['eventid'])) {
    $eventid = $_GET['eventid'];
} else {
    // redirect to error page
    die("Error.");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="google-signin-client_id" content="251137415595-uttj6cdrkgfahoc0hffe2je2gt29utbo.apps.googleusercontent.com">
<title>Personal Website</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <link rel="stylesheet" type="text/css" href="styles/accordion.css" />

    <!-- bootstrap toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

</head>

<script type="text/javascript">
$(document).ready(function() {
  $('.collapse.in').prev('.panel-heading').addClass('active');
  $('#accordion, #bs-collapse')
    .on('show.bs.collapse', function(a) {
      $(a.target).prev('.panel-heading').addClass('active');
    })
    .on('hide.bs.collapse', function(a) {
      $(a.target).prev('.panel-heading').removeClass('active');
    });
});
</script>

<body>

<?php include('header.php') ?>

<div class="content">

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <iframe src="https://calendar.google.com/calendar/embed?src=aij3i20k4v1qauoh199hs9metg%40group.calendar.google.com&ctz=America/Chicago" style="border: 0" width="800" height="600" frameborder="0" scrolling="no"></iframe>
    </div>
    <div class="col-sm-3"></div>
</div>

<?php
    $event = $mysqli->query("SELECT * FROM events WHERE id=$eventid")->fetch_all(MYSQLI_ASSOC)[0];
    $name = $event['name'];
    $starttime = $event['starttime'];
    $endtime = $event['endtime'];
    $description = $event['description'];
    $location = $event['location'];
    $notes = $event['notes'];
?>

<div class="event-wrapper">
    <div class="event-title">
        <h2> <?php echo $name; ?> </h2>
        <h4> <?php echo $starttime . " - " . $endtime; ?> </h4>
        <p> <?php echo $description; ?></p>
        <form id="attendanceForm" method="POST" action="attendance-record.php">
            <div class="checkbox">
                <input type="hidden" name="sent" value="true">
                Going? <input type="checkbox" value="true" name="going" data-toggle="toggle" data-on="Yes" data-off="No" onclick="$('#attendanceForm').submit();">
            </div>
        </form>
    </div>
    <div class="event-header" data-toggle="collapse" data-target="#collapse1">Who's Going?</div>
        <div id="collapse1" class="collapse event-section">
            Users who have responded "yes":
            <ul>
                <li>Jacob Mack</li>
                <li>Evan Whiting</li>
                <li>Michel Ge</li>
                <li>Nathan Burlis</li>
            </ul>
        </div>
    <div class="event-header" data-toggle="collapse" data-target="#collapse2">Where At?</div>
        <div id="collapse2" class="collapse event-section"><?php echo $location; ?></div>
    <div class="event-header" data-toggle="collapse" data-target="#collapse3">What to Bring?</div>
        <div id="collapse3" class="collapse event-section"><?php echo $notes; ?></div>
</div>
</div>
</body>
</html>
