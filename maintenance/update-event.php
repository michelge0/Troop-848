<?php

include('../database-helper.php');

$message = "Oops, something went wrong.";

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$location = $_POST['location'];
	$starttime = $_POST['starttime'];
	$endtime = $_POST['endtime'];
	$notes = $_POST['notes'];
	$email = isset($_POST['email']);

	$type = $_GET['type'];

	if ($type == "edit") {
		$id = $_GET['id'];
		$statement = $mysqli->prepare("UPDATE events SET name = ?, description = ?, location = ?, starttime = ?, endtime = ?, notes = ? WHERE id=$id");
		$statement->bind_param("ssssss", $name, $description, $location, $starttime, $endtime, $notes);
		$statement->execute();

		if ($email) {
			// send mass email
		}

		$message = "Edit successful!";

	} else if ($type == "add") {
		$statement = $mysqli->prepare("INSERT INTO events (name, description, location, starttime, endtime, notes) VALUES (?, ?, ?, ?, ?, ?)");
		$statement->bind_param("ssssss", $name, $description, $location, $starttime, $endtime, $notes);
		$statement->execute();
		echo "Got here";
		var_dump($statement->get_result());
		if ($email) {
			// send mass email
		}

		$message = "Successfully added " . $name . "!";
	}

	header("Location: ../calendar.php");
	die();

} else {
	echo $message;
}

?>