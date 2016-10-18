<?php

require('../helper/database-helper.php');
require('../helper/mail.php');

if (isset($_POST['name'])) {
	$input_attempt = $_POST['name'];
	$id = $_GET['id']; // id of row to be deleted

	$counselor_id = $mysqli->query("SELECT * FROM MB_Counselors WHERE id=$id")->fetch_assoc()['counselor_id'];
	$expected_name = $mysqli->query("SELECT * FROM roster WHERE id=$counselor_id")->fetch_assoc()['name'];
}

if ($input_attempt === $expected_name) {
		$statement = $mysqli->query("DELETE FROM MB_Counselors WHERE id=?");
	} else {
		die("Sorry, you didn't spell the name right.");
	}
}



?>