<?php

include('../helper/database-helper.php');
include('../helper/mail.php');

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
			$to = get_event_emails('onedit');
			$subject = "Event Changed: " . $name;
			$text = "This is an automatic message letting you know that " . $name . " has just been changed.";
			$html = "<p>" . $text . "</p>";
			send_mail($to, $subject, $text, $html);
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
			$to = get_event_emails('oncreate');
			$subject = "Event Created: $name";
			$text = "This is an automatic message letting you know that $name has just been created.";
			$html = "<p>$text</p>";
			send_mail($to, $subject, $text, $html);
		}
	}

	header("Location: ../calendar.php");
	die();

}

?>