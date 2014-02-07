<?php

class aprsTime {
	static function fromUnixtime($time) {
		return sprintf('%06dz', date('dHi', $time));
	}

	static function now() {
		return self::fromUnixtime(time());
	}

}
