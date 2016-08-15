<?php

include('../database-helper.php');

$message = "Oops, something went wrong.";

if (isset($_POST['title'])) {
	$title = $_POST['title'];
	$author = $_POST['author'];
	$date = $_POST['date'];
	$content = $_POST['content'];
	$blogid = $_POST['blogid'];

	$blogname = urldecode($_GET['table']);

	$type = $_GET['type'];

	if ($type == "edit") {
		$id = $_GET['id'];
		$statement = $mysqli->prepare("UPDATE `$blogname` SET title = ?, author = ?, `date` = ?, content = ? WHERE id=$id");
		$statement->bind_param("ssss", $title, $author, $date, $content);
		$statement->execute();

		$message = "Edit successful!";

	} else if ($type == "add") {
		$statement = $mysqli->prepare("INSERT INTO `$blogname` (title, author, `date`, content) VALUES (?, ?, ?, ?)");
		$statement->bind_param("ssss", $title, $author, $date, $content);
		$statement->execute();

		$message = "Successfully added " . $name . "!";
	}

	header("Location: ../blog.php?blogid=$blogid");
	die();

} else {
	echo $message;
}

?>