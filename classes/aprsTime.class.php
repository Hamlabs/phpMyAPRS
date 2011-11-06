<?php

class aprsTime {
	static function fromUnixtime($time) {
		return sprintf('%dz', date('dHi', $time));
	}

	static function now() {
		return self::fromUnixtime(time());
	}

}
