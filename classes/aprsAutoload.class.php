<?php

$__PHPMYAPRSCONF = parse_ini_file('config.ini', true);

function __autoload($class_name) {
	global $__PHPMYAPRSCONF;

	require_once(sprintf('%s/%s.class.php', $__PHPMYAPRSCONF['local']['classpath'], $class_name));
}

