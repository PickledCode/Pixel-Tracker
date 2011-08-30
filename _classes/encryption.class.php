<?php

class Encryption {
	public $key = "";
	
	function __construct ($theKey) {
		$this->key = $theKey;
	}
	
	function encrypt ($buffer) {
		return base64_encode($this->rc4Encrypt($this->key, $buffer));
	}
	
	function decrypt ($buffer) {
		$decoded = base64_decode($buffer);
		return $this->rc4Encrypt($this->key, $decoded);
	}
	
	/**
	 * Code taken from http://farhadi.ir/downloads/rc4.php
	 */
	private function rc4Encrypt ($key, $pt) {
		$s = array();
		for ($i=0; $i<256; $i++) {
			$s[$i] = $i;
		}
		$j = 0;
		$x;
		for ($i=0; $i<256; $i++) {
			$j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
			$x = $s[$i];
			$s[$i] = $s[$j];
			$s[$j] = $x;
		}
		$i = 0;
		$j = 0;
		$ct = '';
		$y;
		for ($y=0; $y<strlen($pt); $y++) {
			$i = ($i + 1) % 256;
			$j = ($j + $s[$i]) % 256;
			$x = $s[$i];
			$s[$i] = $s[$j];
			$s[$j] = $x;
			$ct .= $pt[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
		}
		return $ct;
	}
}

?>
