<?php

require 'vendor/autoload.php';
require 'database-helper.php';

function send_mail($to, $subject, $text, $html) {
	$sendgrid = new SendGrid('troop848', 'fabellabuddy20');
	$email = new SendGrid\Email();
	$email->addTo($to)
	    ->setFrom('admin@troop848.com')
	    ->setSubject($subject)
	    ->setText($text)
	    ->setHtml($html);
	$sendgrid->send($email);
}

function get_admin_emails() {
	global $mysqli;
	$emails = [];
	
	$result = $mysqli->query("SELECT * FROM roster WHERE permissions='Admin'")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($result); $i++) {
		$emails[] = $result[$i]['email'];
	}

	return $emails;
}

function get_event_emails($condition) {
	global $mysqli;
	$emails = [];

	$result = $mysqli->query("SELECT * FROM email_preferences WHERE $condition=1")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($result); $i++) {
		$emails[] = $result[$i]['email'];
	}

	return $emails;
}

function get_all_emails() {
	global $mysqli;
	$emails = [];

	$result = $mysqli->query("SELECT * FROM email_preferences")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($result); $i++) {
		$emails[] = $result[$i]['email'];
	}

	return $emails;
}

?>