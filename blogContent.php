<?php
$db_user = 'root';
$db_pwd = 'aa5sw8oMFZ7jYrdBepmSiTEpvLfP9X';
$db_server = '54.191.223.200';
$db_name = 'blogs';

$mysqli = new mysqli($db_server, $db_user, $db_pwd, $db_name);
if ($mysqli->connect_error) {
	die("Fuck.");
}

// if ($mysqli->query("INSERT INTO Template (id, title, date, content, imageid) VALUES (12, 'test', '2/3/23', 'hello', 3)") === TRUE) {
// 	echo "good";
// } else {
// 	echo "Error: " . $mysqli->error;
// }

$result = $mysqli->query("SELECT * FROM Template");
while ($row = $result->fetch_assoc()) {
	var_dump($row);
}
?>