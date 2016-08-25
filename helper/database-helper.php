<?php

$db_user = 'root';
$db_pwd = 'aa5sw8oMFZ7jYrdBepmSiTEpvLfP9X';
$db_server = '54.191.223.200';
$db_name = 'blogs';

$mysqli = new mysqli($db_server, $db_user, $db_pwd, $db_name);

// function getDB() {
// 	global $db_user, $db_pwd, $db_server, $db_name;

// 	if (isset($mysqli) && $mysqli instanceof mysqli) {
// 		if (!($mysqli->errno) && ($mysqli->ping()))
// 			return $mysqli;
// 	}

// 	return ($mysqli = new mysqli($db_server, $db_user, $db_pwd, $db_name));
// }

// function sendMassEmail($subject, $message, $mysqli) {
// 	$headers = 'From: admin@troop848.com' . "\r\n" .
// 				'Reply-To: strengthofthepen@gmail.com';

// 	$to = "";
// 	$emails = $mysqli->query("SELECT email FROM roster")->fetch_all(MYSQLI_ASSOC);
// 	if ($emails) {
// 		for ($i = 0; $i < count($emails); $i++) {
// 			$email = $emails[$i]['email'];
// 			$to .= $email . ", ";
// 		}
// 	}

// 	mail($to, $subject, $message, $headers);
// }

?>