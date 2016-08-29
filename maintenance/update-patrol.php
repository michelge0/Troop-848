<?php
include('../helper/database-helper.php');

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$type = $_GET['type'];

	if ($type == "edit") {
		$id = $_GET['id'];

		// get old patrol name
		$old_patrol_name = $mysqli->query("SELECT * FROM patrols WHERE id=$id")->fetch_assoc()['name'];

		// edit patrol name
		$statement = $mysqli->prepare("UPDATE patrols SET name = ? WHERE id=$id");
		$statement->bind_param("s", $name);
		$statement->execute();

		// change all users in this patrol to the new name
		$statement = $mysqli->prepare("UPDATE roster SET patrol = ? WHERE patrol='$old_patrol_name'");
		$statement->bind_param("s", $name);
		$statement->execute();

	} else if ($type == "add") {
		$statement = $mysqli->prepare("INSERT INTO patrols (name) VALUES (?)");
		$statement->bind_param("s", $name);
		$statement->execute();
	}

	header("Location: ../roster.php");
	die();

} else {
	echo "Error of some kind.";
}
?>
