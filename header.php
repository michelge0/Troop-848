<script src="scripts/logout.js"></script>

<header class="header"> TROOP <strong>848</strong>
	<div class="panel">
		<button onclick="logOut();"> sign out </button>
		<button onclick="window.location = 'my-account.php';""> my account </button>
		<p> signed in as <?php echo $_SESSION['name']?> </p>
	</div>
</header>

<ul class="nav-bar" data-spy="affix" data-offset-top="160">
<li><a href="roster-admin.php">Roster</a></li>
<li class="dropdown-link">
	Scouting
	<div class="dropdown-content">
	<?php
		$result = $mysqli->query("SELECT * FROM categories WHERE category='scouting'")->fetch_all(MYSQLI_ASSOC);
		if ($result) {
			for ($i = 0; $i < count($result); $i++) {
				$row = $result[$i];
				$id = $row['id'];
				$name = $row['blogname'];
				$link = "blog.php?blogid=" . $id;
				echo "<a href='$link'>$name</a>";
			}
		}
	?>
	</div>
</li>
<li class="dropdown-link">
	Adventures
	<div class="dropdown-content">
	<?php
		$result = $mysqli->query("SELECT * FROM categories WHERE category='adventures'")->fetch_all(MYSQLI_ASSOC);
		if ($result) {
			for ($i = 0; $i < count($result); $i++) {
				$row = $result[$i];
				$id = $row['id'];
				$name = $row['blogname'];
				$link = "blog.php?blogid=" . $id;
				echo "<a href='$link'>$name</a>";
			}
		}
	?>
	</div>
</li>
<li><a href="calendar.php">Calendar</a></li>
</ul>