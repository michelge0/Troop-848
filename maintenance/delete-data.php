<?php

include('../database-helper.php');

$message = "Oops, something went wrong. Did you spell the user's name right?";

if (isset($_POST['name'])) {
	$input_attempt = $_POST['name'];
	$id = $_GET['id']; // id of row to be deleted
	$table = $_GET['table'];

	$statement = $mysqli->prepare("SELECT * FROM `$table` WHERE id=?");
	$statement->bind_param("i", $id);
	$statement->execute();
	$expected_row = $statement->get_result()->fetch_assoc();
	$expected_name = $table === "roster" || $table === "events" ? $expected_row['name'] : $expected_row['title'];

	if ($input_attempt === $expected_name) {
		$statement = $mysqli->prepare("DELETE FROM `$table` WHERE id=?");
		$statement->bind_param("i", $id);
		$statement->execute();
	} else {
		die("Sorry, you didn't spell the name right.". $input_attempt . " expected: " . $expected_name. " table " . $table);
	}
	
	if ($table === "roster") {
		header("Location: ../roster.php");
	} else if ($table === "events") {
		// TODO: SEND MASS EMAIL
		header("Location: ../calendar.php");
	// for blog posts (table name varies) 
	} else {
		$blogid = $_GET['id'];
		header("Location: ../blog.php?blogid=$blogid");
	}
	
	die();
}
echo $message;

?>