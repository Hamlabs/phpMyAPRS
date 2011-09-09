<?php

class aprsConfig {

	static function get($section, $key) {
		global $__PHPMYAPRSCONF;
		return $__PHPMYAPRSCONF[$section][$key];
	}

	static function getQueue() {
		$classname = self::get('local', 'queue');
		return $classname::getInstance();
	}

}
