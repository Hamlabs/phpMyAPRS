<?php

class aprsPacketQueueIPC {

	private static $instance;

	private $q;
	private $msgtype = 1;

	private function __construct() {
		global $__PHPMYAPRSCONF;
		$this->q = msg_get_queue($__PHPMYAPRSCONF['ipcqueue']['key']);
	}

	public static function getInstance() {
		if(!isset(self::$instance)) {
			$classname = __CLASS__;
			self::$instance = new $classname();
		}
		return self::$instance;
	}

	public function put($packet) {
		msg_send($this->q, $this->msgtype, $packet);
	}

	public function get() {
		$msg = '';
		if(msg_receive($this->q, $this->msgtype, $this->msgtype, 255, $msg)) {
			return $msg;
		} else {
			return false;
		}
	}

}
