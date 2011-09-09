<?php

class aprsPacketQueueIPC {

	var $q;
	var $msgtype = 1;

	function __construct() {
		global $__PHPMYAPRSCONF;
		$this->q = msg_get_queue($__PHPMYAPRSCONF['local']['ipcqueue']);
	}

	function put($packet) {
		msg_send($this->q, $this->msgtype, $packet);
	}

	function get() {
		$msg = '';
		if(msg_receive($this->q, $this->msgtype, $this->msgtype, 255, $msg)) {
			return $msg;
		} else {
			return false;
		}
	}

}
