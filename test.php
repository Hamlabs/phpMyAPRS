<?php
require_once('autoload.php');

$q = new aprsPacketQueueIPC();

if(empty($argv[1])) {
	while($foo = $q->get()) {
		var_dump($foo);
	}
} else {
	$q->put($argv[1]);
}

