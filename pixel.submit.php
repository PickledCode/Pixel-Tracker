<?php
require_once dirname(__FILE__) . '/_classes/_include.php';
$_response = array();

$_status = 500;
$_response['step'] = 0;

if (isset($_POST['email'])) {
	$email = $_POST['email'];
	$_response['step'] = 1;
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
		$_response['step'] = 2;
		
		$link = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/pixel.png';
		
		$encryptor = new Encryption('iHateMonkeys');
		$encrypt = $encryptor->encrypt($email);
		$_response['link'] = $link . '?e=' . urlencode($encrypt);
		$_status = 200;
	}
}

header("HTTP/1.0 $_status Pixel Fucked");
echo json_encode($_response);

exit;
?>
