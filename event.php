<?php

require('helper/authenticate.php');
require('helper/database-helper.php');

if (isset($_GET['eventid'])) {
    $eventid = $_GET['eventid'];
} else {
    die("Error: the event you're looking for doesn't seem to exist.");
}

$name = $_SESSION['name'];
$userid = $_SESSION['id'];

if (isset($_POST['going'])) {
    $going = $_POST['going'];

    // updates the response, creating a new response if it doesn't exist already
    $mysqli->query("UPDATE responses SET response=$going WHERE userid=$userid AND eventid=$eventid");
    if ($mysqli->affected_rows == 0) {
        $mysqli->query("INSERT INTO responses (userid, eventid, response) VALUES ($userid, $eventid, $going)");
    }

    die();
}

$going = $mysqli->query("SELECT * FROM responses WHERE userid=$userid AND eventid=$eventid")->fetch_assoc()['response'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php require('helper/imports.php'); ?>
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

        // detect changes
        $('#going').change(function() {

            var checked = this.checked ? 1 : 0;
            
            $.ajax({
                data: {going: checked},
                type: "POST",
                dataType: "text",
            });
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
        <div class="checkbox"> Going?
            <?php if ($going) : ?>
            <input type="checkbox" id="going" data-toggle="toggle" data-on="Yes" data-off="No" checked>
            <?php else : ?>
            <input type="checkbox" id="going" data-toggle="toggle" data-on="Yes" data-off="No">
            <?php endif; ?>
        </div>
    </div>
    <div class="event-header" data-toggle="collapse" data-target="#collapse1">Who's Going?</div>
        <div id="collapse1" class="collapse event-section">
            Users who have responded "yes":
            <ul>
                <?php
                    $responses = $mysqli->query("SELECT * FROM responses WHERE eventid=$eventid");
                    while ($response = $responses->fetch_assoc()) {
                        if ($response['response'] == 1) {
                            $userid = $response['userid'];
                            $name = $mysqli->query("SELECT * FROM roster WHERE id=$userid")->fetch_assoc()['name'];
                            echo "<li>$name</li>";
                        }
                    }
                ?>
            </ul>
        </div>
    <div class="event-header" data-toggle="collapse" data-target="#collapse2">Where At?</div>
        <div id="collapse2" class="collapse event-section"><?php echo $location; ?></div>
    <div class="event-header" data-toggle="collapse" data-target="#collapse3">Notes</div>
        <div id="collapse3" class="collapse event-section"><?php echo $notes; ?></div>
</div>
</div>
</body>
</html>
