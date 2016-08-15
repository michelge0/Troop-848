<?php


$to = "strengthofthepen@gmail.com";
$subject = "test email";
$message = "Hey there.";
$headers = "From: webmaster@troop848.com";

mail($to, $subject, $message, $headers) or die("Email failed . . . ");


?>