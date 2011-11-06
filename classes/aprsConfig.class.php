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

	static function getVersionArray() {
		return array(0,0,1);
	}

	static function getVersion() {
		$v = self::getVersionArray();
		return sprintf('phpMyAPRS %d.%d.%d', $v[0], $v[1], $v[2]);
	}

	static function getAX25dst() {
		$v = self::getVersionArray();
		return sprintf('APZ%d%d%d', $v[0], $v[1], $v[2]);
	}

}
