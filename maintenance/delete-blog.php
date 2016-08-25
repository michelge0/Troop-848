<?php

require('../helper/database-helper.php');
require('../helper/mail.php');

if (isset($_POST['name'])) {
	$attempted_name = $_POST['name'];
	$blogid = $_POST['blogid'];

	$blogname = $mysqli->query("SELECT * FROM blogs WHERE id=$blogid")->fetch_assoc()['blogname'];
	if ($blogname === $attempted_name) {

		$post_text = "";
		$allposts = $mysqli->query("SELECT * FROM `$blogname`")->fetch_all(MYSQLI_ASSOC);
		for ($i = 0; $i < count($allposts); $i++) {
			$post = $allposts[$i];
			$post_text .= "<h1>" . $post['title'] . "</h1> \n";
			$post_text .= "<h3> by " . $post['author'] . " on " . $post['date'] . "</h3> \n";
			$post_text .= "<p>" . $post['content'] . "</p> \n";
		}

		$to = get_admin_emails();
		$subject = "Blog Deleted: " . $blogname;
		$text = "This is an automatic message letting you know that " $blogname " has just been deleted. \n
				All of its posts have been deleted as well, but a record of them is pasted below. \n" . $post_text;
		$html = "<p>" . $text . "</p>";
		send_mail($to, $subject, $text, $html);

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