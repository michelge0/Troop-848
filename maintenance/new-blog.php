<?php

include('../database-helper.php');

$message = "Oops, something went wrong.";

if (isset($_POST['name'])) {

	$name = $_POST['name'];
	$category = $_POST['category'];
	$blogid = $_POST['blogid'];

	$statement = $mysqli->prepare("CREATE TABLE `$name` (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`title` tinytext,
		`date` tinytext,
		`content` mediumtext,
		`imageid` int(11) DEFAULT NULL,
		`author` tinytext
		);") or die("Sorry, there was an error and the blog wasn't created. Maybe the name you tried already exists, or is a reserved keyword. (Try naming the blog something else.)");
	$statement->execute();

	$statement2 = $mysqli->prepare("INSERT INTO categories (blogname, category) VALUES (?, ?)");
	$statement2->bind_param("ss", $name, $category);
	$statement2->execute();

	header("Location: ../blog.php?blogid=$blogid");
	die();

} else {
	echo $message;
}

?>