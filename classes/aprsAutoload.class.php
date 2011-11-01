<?php

class aprsAutoload {
	static function autoload($class_name) {
		$filename = sprintf('%s/%s.class.php', aprsConfig::get('local', 'classpath'), $class_name);
		if(file_exists($filename)) {
			require_once($filename);
		}
	}
}

