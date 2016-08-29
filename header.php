<script src="scripts/logout.js"></script>

<header class="header"> <a href="index.php">TROOP <strong>848</strong></a>
	<div class="panel">
		<button onclick="logOut();"> sign out </button>
		<button onclick="window.location = 'dashboard.php';""> dashboard </button>
		<p> signed in as <?php echo $_SESSION['name']?> </p>
	</div>
</header>

<ul class="nav-bar" data-spy="affix" data-offset-top="160">
<li><a href="index.php">Home</a></li>
<li><a href="roster.php">Roster</a></li>
<li class="dropdown-link">
	Scouting
	<div class="dropdown-content">
	<?php
		$result = $mysqli->query("SELECT * FROM blogs WHERE category='scouting'")->fetch_all(MYSQLI_ASSOC);
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
		$result = $mysqli->query("SELECT * FROM blogs WHERE category='adventures'")->fetch_all(MYSQLI_ASSOC);
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