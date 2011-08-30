<?php


class EmailList {
	private $fp;
	
	public static $domains = array(
		'allowsPlus' => array(
			'me.com', 'mac.com', 'gmail.com', 'google.com'
		),
		'allowsDots' => array(
			'gmail.com', 'google.com'
		)
	);
	
	function __construct ($textFile) {
		if (!file_exists($textFile)) {
			$this->fp = fopen($textFile, 'w+');
		} else {
			$this->fp = fopen($textFile, 'r+');
		}
	}
	
	public function readEmail () {
		if (!feof($this->fp)) {
			return rtrim(fgets($this->fp));
		} else {
			return false;
		}
	}
	
	public function containsEmail ($anEmail) {
		$eLow = self::compressAddress($anEmail);
		fseek($this->fp, 0);
		while (true) {
			$str = $this->readEmail();
			if ($str == false) return false;
			if (self::compressAddress($str) == $eLow) {
				return true;
			}
		}
		return false;
	}
	
	public function addEmail ($anEmail) {
		if ($this->containsEmail($anEmail)) {
			return;
		}
		fseek($this->fp, 0, SEEK_END);
		fwrite($this->fp, self::compressAddress($anEmail) . "\n");
	}
	
	public function delEmail ($anEmail) {
		if (!$this->containsEmail($anEmail)) {
			return;
		}
		$readPtr = 0;
		$writePtr = 0;
		$compE = self::compressAddress($anEmail);
		while (1) {
			fseek($this->fp, $readPtr);
			$str = $this->readEmail();
			$justRead = ftell($this->fp) - $readPtr;
			$readPtr += $justRead;
			if (self::compressAddress($str) != $compE) {
				fseek($this->fp, $writePtr);
				fwrite($this->fp, $str . "\n");
				$writePtr += $justRead;
			}
		}
		ftruncate($this->fp, $writePtr);
	}
	
	public function closeFile () {
		fclose($this->fp);
	}
	
	public static function in_array_i ($string, $array) {
		for ($i = 0; $i < count($array); $i++) {
			if (strtolower($array[$i]) == strtolower($string)) {
				return true;
			}
		}
		return false;
	}
	
	public static function compressAddress ($anAddress) {
		$comps = explode('@', $anAddress, 2);
		if (self::in_array_i($comps[1], self::$domains['allowsPlus'])) {
			// remove +
			$comps[0] = preg_replace('/\\+.*/', '', $comps[0]);
		}
		if (self::in_array_i($comps[1], self::$domains['allowsDots'])) {
			// remove dots
			$comps[0] = str_replace('.', '', $comps[0]);
		}
		return strtolower($comps[0] . '@' . $comps[1]);
	}
}

?>