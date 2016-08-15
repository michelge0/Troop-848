<?php

include('../database-helper.php');

if (isset($_POST['name'])) {
	$attempted_name = $_POST['name'];
	$blogid = $_POST['blogid'];

	$blogname = $mysqli->query("SELECT * FROM blogs WHERE id=$blogid")->fetch_assoc()['blogname'];
	if ($blogname === $attempted_name) {

		// delete table
		$statement = $mysqli->prepare("DROP TABLE `$blogname`");
		$statement->execute();

		// remove record from blogs
		$mysqli->query("DELETE FROM blogs WHERE id=$blogid");

		header("Location: ../index.php");
		die();
	}

	die("Error: blog wasn't deleted successfully. Maybe you spelled its name wrong?");
}

?>