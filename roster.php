<?php
	include("database-helper.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Personal Website</title>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script> -->
    <link href="bootstrap-3.3.6-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.6-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
	<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
    <script src="bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
</head>

<body>

<header class="header">TROOP <strong>848</strong></header>

<ul class="nav-bar" data-spy="affix" data-offset-top="160">
<li><a href="#">Announcements</a></li>
<li class="dropdown-link">
	Scouting
	<div class="dropdown-content">
		<a href="#">OA</a>
		<a href="#">Service</a>
		<a href="#">Rank Advancement</a>
		<a href="#">Memories</a>
	</div>
</li>
<li class="dropdown-link">
	Adventures
	<div class="dropdown-content">
		<a href="#">Philmont 2011</a>
		<a href="#">Sea Base 2012</a>
		<a href="#">Philmont 2013</a>
	</div>
</li>
<li><a href="#">Calendar</a></li>
</ul>

<div class="content">
<div class="table-responsive table-hover">
  <table class="table">
    <thead>
    	<tr>
	        <th>Name</th>
	        <th>Patrol</th>
	        <th>Email</th>
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
				$patrol = $row['patrol'];
				$permissions = 0;
				switch($row['permissions']) {
					case 0: $permissions = "User"; break;
					case 1: $permissions = "Editor"; break;
					case 2: $permissions = "Admin"; break;
				}
				echo "<td>$name</td>";
				echo "<td>$patrol</td>";
				echo "<td>$email</td>";
				echo "<td>$permissions</td>";
				echo "</tr>";
			}
		}
    ?>
    </tbody>
  </table>
</div>
</div>
</body>
</html>
