<?php
	require('helper/authenticate.php');
	require('helper/database-helper.php');

	if (isset($_POST['mbName'])) {
		$mbName = $_POST['mbName'];
		$mysqli->query("INSERT INTO MB_List (name) VALUES ('$mbName')");
	}

	if (isset($_POST['counselorID'])) {
		$counselor_id = $_POST['counselorID'];
		if (isset($_GET['badge'])) {
			$badge = $_GET['badge'];

			// check
			$exists = $mysqli->query("SELECT * FROM MB_Counselors WHERE badge='$badge' AND counselor_id=$counselor_id")
							 ->fetch_all(MYSQLI_NUM);
			if (!$exists) {
				$mysqli->query("INSERT INTO MB_Counselors (counselor_id, badge) VALUES ($counselor_id, '$badge')");
			}

		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require('helper/imports.php'); ?>

<script>

	$(document).ready(function() {
		$('#deleteModal').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('id');
    		$("#deleteForm").attr('action', 'maintenance/delete-data.php?table=MB_List&id=' + id);
		});

		$('#deleteCounselorModal').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('id');
    		$("#deleteCounselorForm").attr('action', 'maintenance/delete-data.php?table=MB_Counselors&id=' + id);
		});
	});
	
</script>
</head>

<body>

<?php require('header.php'); ?>

<div class="content">
<?php

	// GET REQUEST
	if (isset($_GET["badge"])) {
		$badge = urldecode($_GET["badge"]);
		echo "<h1 style='color: rgb(150, 0, 0)'>$badge Counselors</h1>"; ?>

		<div class="table-responsive table-hover">
  		<table class="table">
    		<thead>
    		<tr>
		        <th>Name</th>
		        <th>Email</th>
		        <th>Phone</th>
		        <th>Address</th>
    		</tr>
    		</thead>
	    	<tbody>
	    	<?php
    			$counselors = $mysqli->query("SELECT * FROM MB_Counselors WHERE badge = '$badge'")->fetch_all(MYSQLI_ASSOC);
    			if ($counselors) {
	    			for ($j = 0; $j < count($counselors); $j++) {
	    				$counselor_id = $counselors[$j]["counselor_id"];
	    				$id = $counselors[$j]["id"];

	    				$data = $mysqli->query("SELECT * FROM roster WHERE id=$counselor_id")->fetch_assoc();
	    				$name = $data['name'];
						$email = $data['email'];
						$phone = $data['phone'];
						$address = $data['address'];

	    				echo "<tr>";
	    				echo "<td>$name</td>";
						echo "<td>$email</td>";
						echo "<td>$phone</td>";
						echo "<td>$address";

						if ($_SESSION['permissions'] >= 1) {
							echo "<button class='btn btn-danger mb-link' data-toggle='modal' data-target='#deleteCounselorModal' data-id='$id'>Delete Counselor</button>";
						}
						echo "</td></tr>";
	    			}
    			}
			?>

			<?php if ($_SESSION['permissions'] >= 1) : ?>
			<button class='btn btn-default' data-toggle='modal' data-target='#addCounselorModal' data-id='$id'>Add Counselor</button>
			<?php endif; ?>

    		</tbody>
  		</table>
		</div>
	<?php
	}
	?>

	<!-- MAIN LIST -->
	<h1 style="color: rgb(150, 0, 0)">Merit Badges</h1>
	<p>Click on a merit badge to see its Troop 848 counselors.</p>
	<p>Editors / Admins: to edit a merit badge, click on the white box around it.</p>
	<ul id="mbs" class="list-group" style="width: 500px">
	<?php
	$merit_badges = $mysqli->query("SELECT * FROM MB_List")->fetch_all(MYSQLI_ASSOC);
	if ($merit_badges) {
		for ($i = 0; $i < count($merit_badges); $i++) {
			$name = $merit_badges[$i]["name"];
			$url = urlencode($name);
			$id = $merit_badges[$i]["id"];
			echo "<li class='list-group-item'>$name";
			echo "<a href='counselors.php?badge=$url'><button class='btn btn-default mb-link'>Counselors >></button></a>";

			if ($_SESSION['permissions'] >= 1) {
				echo "<button class='btn btn-danger mb-link' data-toggle='modal' data-target='#deleteModal' data-id='$id'>Delete MB</button>";
			}	

			echo "</li>";
		}
	}
	?>
	</ul>

<?php if ($_SESSION['permissions'] >= 1) : ?>
<button class='btn btn-default' data-toggle='modal' data-target='#addMBModal' data-id='$id'>New MB</button>

<!-- delete merit badge modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete Merit Badge</h4>
      </div>
      <form id="deleteForm" method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<p>You're about to delete this merit badge. This will also delete all the information for the counselors of this badge. To continue, type the badge's name below.</p>
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

<!-- delete counselor modal -->
<div class="modal fade" id="deleteCounselorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete Merit Badge</h4>
      </div>
      <form id="deleteCounselorForm" method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<p>You're about to remove this adult from the counselors list for this merit badge. This will not delete the counselor's roster information. To continue, type the counselor's name into the space below.</p>
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

<!-- add counselor modal -->
<div class="modal fade" id="addCounselorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">New Merit Badge</h4>
      </div>
      <form id="addCounselorForm" method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<p> Select the adult you would like to add as a merit badge counselor. If you do not see who you you're looking for, add them first on the Roster page. </p>
	    		<select name="counselorID">
	    			<?php
	    				$adults = $mysqli->query("SELECT * FROM roster WHERE patrol = 'Adults'")->fetch_all(MYSQLI_ASSOC);
	    				for ($i = 0; $i < count($adults); $i++) {
	    					$name = $adults[$i]["name"];
	    					// sql database stores value of id in roster column
	    					$id = $adults[$i]["id"];
	    					echo "<option value='$id'>$name</option>";
	    				}
	    			?>
	    		</select>
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

<!-- add mb modal -->
<div class="modal fade" id="addMBModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">New Merit Badge</h4>
      </div>
      <form method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<label>Merit Badge Name:</label>
	    		<input type="text" class="form-control" name="mbName">
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

<?php endif; ?>

</div>
</body>
</html>
