<?php

class aprsObjectDispatcher {
	static function dispatch($raw) {
		$split = explode(':', $raw, 2);
		if(substr($raw, 0, 1) == '#') return false; // Comment lines from APRS-IS are ignored
		switch(true) {
			case preg_match('/^;[A-Za-z0-9_\ ]{9}\*/', $split[1]):
				return aprsObject::dispatch($raw);
			case substr($split[1], 0, 1) == '@':
			case substr($split[1], 0, 1) == '=':
			case substr($split[1], 0, 1) == '!':
			case substr($split[1], 0, 1) == '/':
				return aprsPosition::dispatch($raw);
			case substr($split[1], 0, 1) == '>':
				return aprsStatus::dispatch($raw);
			default:
				return aprsStatus::dispatch($raw);
		}
	}
	
	// Er ikke sikker pÎ hvordan jeg vil lÀse dette...
	static function old_dispatch($raw) {
		$match = array();
		switch(true) {
			case preg_match('/^[A-Z0-9]+(-[0-9]+)?\>[a-zA-Z0-9\-\*,]+\:/', $raw, $match):
				var_dump($match);
				return aprsMessage::dispatch($raw);
			default:
				printf("%s: Could not dispatch [%s]\n", __METHOD__, $raw);
				return false;
		}
	}
}
