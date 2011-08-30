<?php
require_once dirname(__FILE__) . '/_classes/_include.php';
$_response = array();

$_status = 500;

if (isset($_POST['email'])) {
	$email = $_POST['email'];
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
		$encryptor = new Encryption('iHateMonkeys');
		$encrypt = $encryptor->encrypt($email);
		$_response['link'] = '/pixel.png?e=' . urlencode($encrypt);
		$_status = 200;
	}
}

header("HTTP/1.0 $_status Pixel Fucked");
echo json_encode($_response);

exit;
?>
