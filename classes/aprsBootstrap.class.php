<?php

// This class has one job:
// Take care of the chicken-and-egg problem where the autoloader needs the config file,
// and you cannot really parse the config file without the autoloader in place.
class aprsBootstrap {
	static function boot($configfile) {
		// Parse configfile
		if(file_exists($configfile)) {
			$config = parse_ini_file($configfile, true);
		} else {
			throw new Exception("Cannot find $configfile");
		}
		// Include files for aprsConfig and aprsAutoload
		require_once(sprintf('%s/%s.class.php', $config['local']['classpath'], 'aprsConfig'));
		require_once(sprintf('%s/%s.class.php', $config['local']['classpath'], 'aprsAutoload'));

		// Load config
		aprsConfig::load($config, true);

		// Register autoloader
		spl_autoload_register('aprsAutoload::autoload');

		// We're done!
	}
}

