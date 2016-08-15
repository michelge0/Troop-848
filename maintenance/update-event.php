<?php

include('../database-helper.php');

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$location = $_POST['location'];
	$starttime = $_POST['starttime'];
	$endtime = $_POST['endtime'];
	$notes = $_POST['notes'];
	$email = isset($_POST['email']);

	$type = $_GET['type'];
	$id = $_GET['id'];

	if ($type == "edit") {
		$statement = $mysqli->prepare("UPDATE events SET name = ?, description = ?, location = ?, starttime = ?, endtime = ?, notes = ? WHERE id=$id");
		$statement->bind_param("ssssss", $name, $description, $location, $starttime, $endtime, $notes);
		$statement->execute();

		if ($email) {
			// send mass email
		}

		$message = "Edit successful!";

	} else if ($type == "add") {

		// inserts this record into events
		$statement = $mysqli->prepare("INSERT INTO events (name, description, location, starttime, endtime, notes) VALUES (?, ?, ?, ?, ?, ?)");
		$statement->bind_param("ssssss", $name, $description, $location, $starttime, $endtime, $notes);
		$statement->execute();

		// auto-generates a blog post corresponding to this event
  //   	$author = "Troop 848";
  //       $name = "Event: " . $name;

		// $statement = $mysqli->prepare("INSERT INTO events_blog (title, `date`, content, author) VALUES (?, ?, ?, ?, ?)");
		// $statement->bind_param("ssss", $name, $starttime, $description, $author);
		// $statement->execute();

		// $id = $mysqli->insert_id;
  //       $url = "event.php?eventid=$id";

  //       $mysqli->query("UPDATE events_blog SET url='$url' WHERE id=$id");

		if ($email) {
			// send mass email
		}
	}

	header("Location: ../calendar.php");
	die();

}

?>