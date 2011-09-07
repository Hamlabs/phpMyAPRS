<?php

function __autoload($class_name) {
	require_once($class_name . '.class.php');
}

$__CONF = parse_ini_file('config.ini', true);
