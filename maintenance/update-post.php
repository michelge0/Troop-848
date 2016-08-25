<?php

require('../helper/database-helper.php');
require('../helper/file-upload-backend.php');

$message = "Oops, something went wrong.";

if (isset($_POST['title'])) {
	$title = $_POST['title'];
	$author = $_POST['author'];
	$date = $_POST['date'];
	$content = $_POST['content'];
	$blogid = $_POST['blogid'];

	$blogname = urldecode($_GET['table']);

	$image = $_FILES['imageUpload'];

	$type = $_GET['type'];

	if ($type == "edit") {
		
		$id = $_GET['id'];

		$old_image_name = $mysqli->query("SELECT * FROM `$blogname` WHERE id=$id")->fetch_assoc()['image'];

		edit_file($blogname, $id, $old_image_name, $image);

		$statement = $mysqli->prepare("UPDATE `$blogname` SET title = ?, author = ?, `date` = ?, content = ? WHERE id=$id");
		$statement->bind_param("ssss", $title, $author, $date, $content);
		$statement->execute();

		$message = "Edit successful!";

	} else if ($type == "add") {

		upload_file($image);
		$new_image_name = $image['name'];

		$statement = $mysqli->prepare("INSERT INTO `$blogname` (title, author, `date`, content, image) VALUES (?, ?, ?, ?, ?)");
		$statement->bind_param("sssss", $title, $author, $date, $content, $new_image_name);
		$statement->execute() or die("Shit");

		$message = "Successfully added " . $name . "!";
	}

	header("Location: ../blog.php?blogid=$blogid");
	die();

} else {
	echo $message;
}

?>