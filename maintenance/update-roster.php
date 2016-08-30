<?php

include('../helper/database-helper.php');

if (isset($_POST['name'])) {
	$name = trim($_POST['name']);
	$email = $_POST['email'];
	$login_email = $_POST['loginEmail'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$patrol = $_POST['patrol'];
	$permissions = $_POST['permissions'];

	$type = $_GET['type'];

	if ($type == "edit") {
		$id = $_GET['id'];
		$statement = $mysqli->prepare("UPDATE roster SET name = ?, email = ?, login_email = ?, address = ?, phone = ?, patrol = ?, permissions = ? WHERE id=$id");
		$statement->bind_param("sssssss", $name, $email, $login_email, $address, $phone, $patrol, $permissions);
		$statement->execute();

	} else if ($type == "add") {
		$statement = $mysqli->prepare("INSERT INTO roster (name, email, login_email, address, phone, patrol, permissions) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$statement->bind_param("sssssss", $name, $email, $login_email, $address, $phone, $patrol, $permissions);
		$statement->execute();

		$statement = $mysqli->prepare("INSERT INTO email_preferences (email) VALUES (?)");
		$statement->bind_param("s", $email);
		$statement->execute();

	}

	header("Location: ../roster.php");
	die();

} else {
	echo "Error of some kind.";
}

?>