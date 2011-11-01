<?php

class aprsConfig {

	static function load($config, $parsed=false) {
		global $__PHPMYAPRSCONF;
		if(!$parsed) {
			$__PHPMYAPRSCONF = parse_ini_file($config, true);
		} else {
			// This is used when the bootstrapper already has parsed the config.
			// No need to do it twice.
			$__PHPMYAPRSCONF = $config;
		}
	}

	static function get($section, $key) {
		global $__PHPMYAPRSCONF;
		return $__PHPMYAPRSCONF[$section][$key];
	}

	static function getQueue() {
		$classname = self::get('local', 'queue');
		return $classname::getInstance();
	}

}
