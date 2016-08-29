<?php

require('../helper/database-helper.php');
// require('file-upload-backend.php');

if (isset($_POST['title'])) {
	$title = $_POST['title'];
	$author = $_POST['author'];
	$date = $_POST['date'];
	$content = $_POST['content'];
	$blogid = $_POST['blogid'];

	$blogname = urldecode($_GET['table']);

	// $image = $_FILES['imageUpload'];

	$type = $_GET['type'];

	if ($type == "edit") {
		
		$id = $_GET['id'];

		// if ($image) {
		// 	$old_image_name = $mysqli->query("SELECT * FROM `$blogname` WHERE id=$id")->fetch_assoc()['image'];
		// 	edit_file($blogname, $id, $old_image_name, $image);
		// }

		$statement = $mysqli->prepare("UPDATE `$blogname` SET title = ?, author = ?, `date` = ?, content = ?, image = ? WHERE id=$id");
		$statement->bind_param("sssss", $title, $author, $date, $content, $image["name"]);
		$statement->execute();

	} else if ($type == "add") {

		// upload_file($image);
		// $new_image_name = $image['name'];

		$statement = $mysqli->prepare("INSERT INTO `$blogname` (title, author, `date`, content, image) VALUES (?, ?, ?, ?, ?)");
		$statement->bind_param("sssss", $title, $author, $date, $content, $new_image_name);
		$statement->execute() or die("Shit");
	}

	header("Location: ../blog.php?blogid=$blogid");
	die();

}
?>