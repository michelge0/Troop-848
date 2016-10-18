<?php

require('../helper/database-helper.php');
require('../helper/mail.php');

$message = "Oops, something went wrong. Did you spell the user's name right?";

if (isset($_POST['name'])) {
	$input_attempt = $_POST['name'];
	$id = $_GET['id']; // id of row to be deleted
	$table = $_GET['table'];

	$statement = $mysqli->prepare("SELECT * FROM `$table` WHERE id=?");
	$statement->bind_param("i", $id);
	$statement->execute();
	$expected_row = $statement->get_result()->fetch_assoc();
	$expected_name = $table === "MB_List" || $table === "roster" || $table === "events" ? $expected_row['name'] : $expected_row['title'];
	if ($table === "MB_Counselors") {
		$counselor_id = $mysqli->query("SELECT * FROM MB_Counselors WHERE id=$id")->fetch_assoc()['counselor_id'];
		$expected_name = $mysqli->query("SELECT * FROM roster WHERE id=$counselor_id")->fetch_assoc()['name'];
		$badge = $mysqli->query("SELECT * FROM MB_Counselors WHERE id=$id")->fetch_assoc()['badge'];
	}

	if ($input_attempt === $expected_name) {
		$statement = $mysqli->prepare("DELETE FROM `$table` WHERE id=?");
		$statement->bind_param("i", $id);
		$statement->execute();
	} else {
		die("Sorry, you didn't spell the name right.");
	}
	
	// for roster
	if ($table === "roster") {
		header("Location: ../roster.php");

	// for events
	} else if ($table === "events") {
		$name = $input_attempt;
		$to = get_event_emails('ondelete');
		$subject = "Event Cancelled: $name";
		$text = "This is an automatic message letting you know that $name has just been cancelled.";
		$html = "<p>$text</p>";
		send_mail($to, $subject, $text, $html);

		header("Location: ../calendar.php");

	// for merit badges
	} else if ($table === "MB_List") {
		header("Location: ../counselors.php");

	// for mb counselors
	} else if ($table === "MB_Counselors") {
		$badge = urlencode($badge);
		header("Location: ../counselors.php?badge=$badge");

	// for blog posts (table name varies) 
	} else {
		// require("file-upload-backend.php");

		// $image_name = $expected_row['image'];
		// delete_file($image_name);		

		$blogid = $_POST['blogid'];
		header("Location: ../blog.php?blogid=$blogid");
	}
	
	die();
}
echo $message;

?>