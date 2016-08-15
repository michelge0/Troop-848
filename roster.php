<?php
	require('authenticate.php');
	require('database-helper.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Personal Website</title>
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>

<body>

<?php require('header.php'); ?>

<div class="content">
<div class="table-responsive table-hover">
  <table class="table">
    <thead>
    	<tr>
	        <th>Name</th>
	        <th>Patrol</th>
	        <th>Email</th>
	        <th>Phone</th>
	        <th>Address</th>
	        <th>Site Rank</th>
    	</tr>
    </thead>
    <tbody>
    <?php
    	$result = $mysqli->query("SELECT * FROM roster")->fetch_all(MYSQLI_ASSOC);
			if ($result) {
				for ($i = 0; $i < count($result); $i++) {
					echo "<tr>";
					$row = $result[$i];
					$name = $row['name'];
					$email = $row['email'];
					$phone = $row['phone'];
					$address = $row['address'];
					$patrol = $row['patrol'];
					$permissions = $row['permissions'];
					echo "<td>$name</td>";
					echo "<td>$patrol</td>";
					echo "<td>$email</td>";
					echo "<td>$phone</td>";
					echo "<td>$address</td>";
					echo "<td>$permissions</td>";

					if ($_SESSION['permissions'] === 2) {
						$id = $row['id'];
						echo "<td><button class=\"btn btn-default\" data-toggle=\"modal\" data-target=\"#mainModal\" data-change-type=\"Edit\" data-user-info=\"".htmlspecialchars(json_encode(array($row)), ENT_QUOTES, 'UTF-8')."\">Edit User</button>";
						echo "     ";
						echo "<button class=\"btn btn-danger\" data-toggle=\"modal\" data-target=\"#deleteModal\" data-id=\"$id\">Delete</button></td>";
					}
				}
			}
    ?>
    </tbody>
  </table>
</div>

<?php if ($_SESSION['permissions'] === 2) : ?>

<button class="btn btn-default" data-toggle="modal" data-target="#mainModal" data-change-type="Add">+</button>

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
	    		<label for="userName">Name:</label>
	    		<input type="text" class="form-control" id="userName" name="name">
	    	</div>
	    	<div class="form-group">
	    		<label for="userEmail">Email:</label>
	    		<input type="text" class="form-control" id="userEmail" name="email">
	    	</div>
	    	<div class="form-group">
	    		<label for="userEmail">Address:</label>
	    		<input type="text" class="form-control" id="userAddress" name="address">
	    	</div>
	    	<div class="form-group">
	    		<label for="userEmail">Phone:</label>
	    		<input type="text" class="form-control" id="userPhone" name="phone">
	    	</div>
	    	<div class="form-group">
	    		<label for="userPatrol">Patrol:</label>
	    		<select class="form-control" id="userPatrol" name="patrol">
	    			<?php
	    				$result = $mysqli->query("SELECT * FROM patrols")->fetch_all(MYSQLI_ASSOC);
						if ($result) {
							for ($i = 0; $i < count($result); $i++) {
								$name = $result[$i]['name'];

								echo "<option value='$name'>$name</option>";
							}
						}
	    			?>
	    		</select>
	    	</div>
	    	<div class="form-group">
	    		<label for="userPerms">Site Rank:</label>
	    		<select class="form-control" id="userPerms" name="permissions">
	    			<option value="User">User</option>
	    			<option value="Editor">Editor</option>
	    			<option value="Admin">Admin</option>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Delete User</h4>
      </div>
      <form id="deleteForm" action="maintenance/delete-user.php" method="POST">
	      <div class="modal-body">
	    	<div class="form-group">
	    		<p> You're about to delete this user from the roster. That means they won't have access to the site anymore. This action cannot be undone, but you can readd the user if you've made a mistake. <strong>To proceed, type the user's name into the field below.</strong></p>
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
	$(document).ready(function() {
		$('#mainModal').on('show.bs.modal', function(e) {
			var changeType = $(e.relatedTarget).data('change-type');

			$('#myModalLabel').html(changeType + " User");

			// if editing user, then the user's existing info is filled in
			if (changeType === "Edit") {
    			var userData = $(e.relatedTarget).data('user-info');
    			$(e.currentTarget).find('input#userName').val(userData[0].name);
    			$(e.currentTarget).find('input#userEmail').val(userData[0].email);
    			$(e.currentTarget).find('input#userPhone').val(userData[0].phone);
    			$(e.currentTarget).find('input#userAddress').val(userData[0].address);
    			$("#userPatrol option[value=\'" + userData[0].patrol + "\']").attr('selected', 'selected');
    			$("#userPerms option[value=\'" + userData[0].permissions + "\']").attr('selected', 'selected');

    			$("form#changeForm").attr('action', 'maintenance/update-roster.php?type=edit&id=' + userData[0].id);

    		// if creating a new user, defaults everything to blank
			} else if (changeType === "Add") {
    			$(e.currentTarget).find('input#userName').val("");
    			$(e.currentTarget).find('input#userEmail').val("");
    			$(e.currentTarget).find('input#userPhone').val("");
    			$(e.currentTarget).find('input#userAddress').val("");
    			$("#userPatrol")[0].selectedIndex = -1;
    			$("#userPerms")[0].selectedIndex = -1;

    			$("form#changeForm").attr('action', 'maintenance/update-roster.php?type=add');
			}
		});

		$('#deleteModal').on('show.bs.modal', function(e) {
			var id = $(e.relatedTarget).data('id');
			$('form#deleteForm').attr('action', 'maintenance/delete-data.php?table=roster&id=' + id);
		});
	});
</script>

<?php endif; ?>

</div>
</body>
</html>
