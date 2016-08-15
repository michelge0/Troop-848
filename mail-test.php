<?php

# Include the Autoloader (see "Libraries" for install instructions)
require 'vendor/autoload.php';
use Mailgun\Mailgun;

# Instantiate the client.
$client = new \Http\Adapter\Guzzle6\Client();

$mailgun = new Mailgun('key-4b59da8b6c05ef4267cdfcd316a3506b', $client);
$domain = "sandboxa6968724f7564c56ae6e449a28b37ed0.mailgun.org";

# Make the call to the client.
$result = $mailgun->sendMessage("$domain",
                  array('from'    => 'Mailgun Sandbox <postmaster@sandboxa6968724f7564c56ae6e449a28b37ed0.mailgun.org>',
                        'to'      => 'Michel Ge <troop848chesterfield@gmail.com>',
                        'subject' => 'Hello Michel Ge',
                        'text'    => 'Congratulations Michel Ge, you just sent an email with Mailgun!  You are truly awesome!  You can see a record of this email in your logs: https://mailgun.com/cp/log .  You can send up to 300 emails/day from this sandbox server.  Next, you should add your own domain so you can send 10,000 emails/month for free.'));
    

?>