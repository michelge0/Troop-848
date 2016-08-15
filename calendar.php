<?php

require('authenticate.php');
require('database-helper.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="google-signin-client_id" content="251137415595-uttj6cdrkgfahoc0hffe2je2gt29utbo.apps.googleusercontent.com">
<title>Personal Website</title>
	<!-- bootstrap -->
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
    <!-- datetime -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" />
    <!-- custom styles -->
    <link rel="stylesheet" type="text/css" href="styles/style.css" />

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <!-- datetime -->
    <script src="scripts/moment.js"></script>
    <!-- bootstrap -->
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <!-- datetime -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

    <!-- bootstrap toggle -->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</head>

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
	<div class="row calendar-events-list">
		<h2 style="margin: 50px"> Upcoming Events </h2>

		<?php if ($_SESSION['permissions'] >= 1) : ?>
		<button class="btn btn-default" style="margin-bottom: 15px" data-toggle="modal" data-target="#mainModal" data-change-type="Add">+</button>
		<?php endif; ?>
		
		<div class="list-group">
			<?php
		    	$result = $mysqli->query("SELECT * FROM events")->fetch_all(MYSQLI_ASSOC);
				if ($result) {
					for ($i = 0; $i < count($result); $i++) {
						echo "<div class=\"list-group-item list-group-item-action\">"; 
						$row = $result[$i];
						$name = $row['name'];
						$starttime = $row['starttime'];
						$description = substr($row['description'], 0, 200) . " . . .";
						$id = $row['id'];
						echo "<h3 class=\"calendar-event-title\">$name</h3>";
						echo "<h4 class=\"calendar-event-date\">$starttime</h4>";
						echo "<p class=\"calendar-description\">$description</p>";
						echo "<div class=\"calendar-link\"><a class=\"btn btn-default\" href=\"event.php?eventid=$id\"> More >> </a></div>";
						echo "<br>";

						if ($_SESSION['permissions'] >= 1) {
							echo "<button class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#mainModal\" data-change-type=\"Edit\" data-event-info=\"".htmlspecialchars(json_encode(array($row)), ENT_QUOTES, 'UTF-8')."\">Edit</button>";
							echo "     ";
							echo "<button class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal\" data-id=\"$id\">Delete</button>";
						}
						echo "</div>";
					}
				}
		    ?>
		</div>
	</div>

<?php if ($_SESSION['permissions'] >= 1) : ?>

<!-- edit user modal -->
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <form id="changeForm" action="maintenance/update-roster.php" method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<label for="eventName">Event Name:</label>
	    		<input type="text" class="form-control" id="eventName" name="name">
	    	</div>
	    	<div class="form-group">
	    		<label for="eventDescription">Description:</label>
	    		<textarea class="form-control" id="eventDescription" rows="5" name="description"></textarea>
	    	</div>
	    	<div class="form-group calendar-start">
	    		<label>Start:</label>
 				<input type="text" class="form-control" id="eventStartTime" name="starttime">
 			</div>
 			<div class="form-group calendar-end">
 				<label>End:</label>
	 			<input type="text" class="form-control" id="eventEndTime" name="endtime">
	 		</div>
		   	<div class="form-group">
	    		<label for="eventLocation">Location:</label>
	    		<input type="text" class="form-control" id="eventLocation" name="location">
	    	</div>	
	    	<div class="form-group">
	    		<p> Use this section for notes on packing, dress, weather, etc. Don't mention things that apply to all outings in general. </p>
	    		<label for="eventNotes">Notes:</label>
	    		<textarea class="form-control" id="eventNotes" rows="3" name="notes"></textarea>
	    	</div>
	    	<div class="checkbox">
	    		Send mass email? <input type="checkbox" value="true" name="email" data-toggle="toggle" data-on="Yes" data-off="No">
	    	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <input type="submit" class="btn btn-primary">
	      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <form id="deleteForm" action="maintenance/cancel-event.php" method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<p> You're about to cancel this event. All users with notifications enabled will be automatically emailed about the cancellation. <strong>To proceed, type the event's name into the field below.</strong></p>
	    		<input type="text" class="form-control" name="name">
	    	</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <input type="submit" class="btn btn-danger">
	      </div>
      </form>
    </div>
  </div>
</div>

<script>
	$(function() {
		$('#eventStartTime').datetimepicker();
		$('#eventEndTime').datetimepicker({
			useCurrent: false
		});
		$('#eventStartTime').on("dp.change", function(e) {
			$('#eventEndTime').data("DateTimePicker").minDate(e.date);
		});
		$('#eventEndTime').on("dp.change", function(e) {
			$('#eventStartTime').data("DateTimePicker").maxDate(e.date);
		});

		$('#mainModal').on('show.bs.modal', function(e) {
			var changeType = $(e.relatedTarget).data('change-type');

			$('#myModalLabel').html(changeType + " Event");


			// if editing user, then the event's existing info is filled in
			if (changeType === "Edit") {
	    		var eventData = $(e.relatedTarget).data('event-info');
    			$(e.currentTarget).find('input#eventName').val(eventData[0].name);
    			$(e.currentTarget).find('textarea#eventDescription').val(eventData[0].description);
    			$(e.currentTarget).find('input#eventStartTime').val(eventData[0].starttime);
    			$(e.currentTarget).find('input#eventEndTime').val(eventData[0].endtime);
    			$(e.currentTarget).find('input#eventLocation').val(eventData[0].location);
    			$(e.currentTarget).find('textarea#eventNotes').val(eventData[0].notes);

    			$("form#changeForm").attr('action', 'maintenance/update-event.php?type=edit&id=' + eventData[0].id);

    		// if creating a new user, defaults everything to blank
			} else if (changeType === "Add") {
    			$(e.currentTarget).find('input#eventName').val("");
    			$(e.currentTarget).find('textarea#eventDescription').val("");
    			$(e.currentTarget).find('input#eventStartTime').val("");
    			$(e.currentTarget).find('input#eventEndTime').val("");
    			$(e.currentTarget).find('input#eventLocation').val("");
    			$(e.currentTarget).find('textarea#eventNotes').val("");

    			$("form#changeForm").attr('action', 'maintenance/update-event.php?type=add');
			}
		});

		$('#deleteModal').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('id');
			$('form#deleteForm').attr('action', 'maintenance/delete-data.php?table=events&id=' + id);
		});
	});
</script>

<?php endif; ?>

<!-- end content -->
</div>

</body>
</html>
