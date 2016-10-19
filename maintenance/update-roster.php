<?php

include('../helper/database-helper.php');

if (isset($_POST['name'])) {
	$name = trim($_POST['name']);
	$email = $_POST['email'];
	$login_email = $_POST['loginEmail'];
	$address = $_POST['address'];
	$phone = $_POST['phone'];
	$patrol = isset($_POST['patrol']) ? $_POST['patrol'] : "Unassigned";
	$permissions = isset($_POST['permissions']) ? $_POST['permissions'] : "User";

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

		$check = $mysqli->query("SELECT * FROM email_preferences WHERE email='$email'");
		if ($check && mysql_num_rows($check) > 0) {
			$statement = $mysqli->query("INSERT INTO email_preferences (email) VALUES ('$email')");
		}

	}

	//header("Location: ../roster.php");
	die();

} else {
	echo "Error of some kind.";
}

?>