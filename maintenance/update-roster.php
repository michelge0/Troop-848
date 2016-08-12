<?php

include('../database-helper.php');

$message = "Oops, something went wrong.";

if (isset($_POST['name'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$patrol = $_POST['patrol'];
	$permissions = $_POST['permissions'];

	$type = $_GET['type'];

	if ($type == "edit") {
		$id = $_GET['id'];
		$statement = $mysqli->prepare("UPDATE roster SET name = ?, email = ?, patrol = ?, permissions = ? WHERE id=$id");
		$statement->bind_param("ssss", $name, $email, $patrol, $permissions);
		$statement->execute();

		$message = "Edit successful!";

	} else if ($type == "add") {
		$statement = $mysqli->prepare("INSERT INTO roster (name, email, patrol, permissions) VALUES (?, ?, ?, ?)");
		$statement->bind_param("ssss", $name, $email, $patrol, $permissions);
		$statement->execute();

		$message = "Successfully added " . $name . "!";
	}

	header("Location: ../roster-admin.php");
	die();

} else {
	echo $message;
}

?>