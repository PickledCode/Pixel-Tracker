<?php
class Logger
{
	private $fp = null;
	
	function __construct($file) {
		if (!file_exists($file)) {
			$this->fp = fopen($file, 'w+');
		} else {
			$this->fp = fopen($file, 'r+');
		}
	}
	function __destruct() {
		fclose($this->fp);
	}
	
	public function debug($msg) {
		$time = time();
		$this->writeMessage("[DEBUG][$time]: $msg \n");
	}
	public function error($msg) {
		$time = time();
		$this->writeMessage("[ERROR][$time]: $msg \n");
	}
	
	private function writeMessage($msg) {
		fseek($this->fp, 0, SEEK_END);
		fwrite($this->fp, $msg);
	}
}
?>
