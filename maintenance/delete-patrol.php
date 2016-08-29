<?php

require('../helper/database-helper.php');
require('../helper/mail.php');

if (isset($_POST['name'])) {
	$input_attempt = $_POST['name'];
	$id = $_GET['id']; // id of row to be deleted

	$statement = $mysqli->prepare("SELECT * FROM patrols WHERE id=?");
	$statement->bind_param("i", $id);
	$statement->execute();
	$expected_name = $statement->get_result()->fetch_assoc()['name'];

	if ($input_attempt === $expected_name) {
		$statement = $mysqli->prepare("DELETE FROM patrols WHERE id=?");
		$statement->bind_param("i", $id);
		$statement->execute();

		$mysqli->query("UPDATE roster SET patrol = 'Unassigned' WHERE patrol='$expected_name'");

	} else {
		die("Sorry, you didn't spell the name right.");
	}
	
	header("Location: ../roster.php");
	die();
}

?>