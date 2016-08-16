<?php

require 'vendor/autoload.php';

function send_mail($to, $subject, $text, $html) {
	$sendgrid = new SendGrid('nobody', 'loathing2627');
	$email = new SendGrid\Email();
	$email->addTo($to)
	    ->setFrom('admin@troop848.com')
	    ->setSubject($subject)
	    ->setText($text)
	    ->setHtml($html);
	$sendgrid->send($email);
}



?>