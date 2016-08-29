<?php

require 'vendor/autoload.php';
require 'database-helper.php';

function send_mail($to, $subject, $text, $html) {
	$sendgrid = new SendGrid('troop848', 'fabellabuddy20');
	$email = new SendGrid\Email();

	$html .= "<p>This email was sent from the Troop 848 website. You can visit it <a href='troop-848.herokuapp.com'>here</a>.</p>";

	$email->addTo($to)
	    ->setFrom('do-not-reply@troop848.com')
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

	$result = $mysqli->query("SELECT * FROM roster")->fetch_all(MYSQLI_ASSOC);
	for ($i = 0; $i < count($result); $i++) {
		$emails[] = $result[$i]['email'];
	}

	return $emails;
}

function get_patrol_emails($user_email) {
	$patrol = $mysqli->query("SELECT * FROM roster WHERE email=`$user_email`")->fetch_assoc()['patrol'];
    $members = $mysqli->query("SELECT * FROM roster")->fetch_all(MYSQLI_ASSOC);
    $patrol_emails = [];

    for ($i = 0; $i < count($members); $i++) {
        $member = $members[$i];
        if ($member['patrol'] === $patrol) {
            $patrol_emails[] = $member['email'];
        }
    }

    return $patrol_emails;
}

?>