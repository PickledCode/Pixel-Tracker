<?php

if (!isset($_GET['e'])) {
	echo "Umm, what the hell are you trying to pull?";
	exit();
}

require_once('_classes/_include.php');

$dec = new Encryption('iFuckMonkeys'); // note the different key for sign-down
$decEmail = $dec->decrypt($_GET['e']);
$eList = new EmailList(dirname(__FILE__) . '/_secret/blocked_emails.dat');
$eList->delEmail($decEmail);
$eList->closeFile();

echo 'Your email has been added to the no-spam list.';

?>