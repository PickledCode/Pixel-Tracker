<?php
require_once dirname(__FILE__) . '/_classes/_include.php';
$_response = array();

if (isset($_POST['email'])) {
	$email = $_POST['email'];
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL) === true) {
		
	}
}

echo json_encode($_response);
exit;
?>
