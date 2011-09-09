<?php
// Copyright (c) 2005-2006 Joachim Henke
// http://base91.sourceforge.net/
// Modified for OOP 2011 by morten@bzzt.no

/** LICENCE
*
*  Copyright (c) 2000-2006 Joachim Henke
*  All rights reserved.
*  
*  Redistribution and use in source and binary forms, with or without
*  modification, are permitted provided that the following conditions are met:
*  
*    - Redistributions of source code must retain the above copyright notice, this
*      list of conditions and the following disclaimer.
*    - Redistributions in binary form must reproduce the above copyright notice,
*      this list of conditions and the following disclaimer in the documentation
*      and/or other materials provided with the distribution.
*    - Neither the name of Joachim Henke nor the names of his contributors may be
*      used to endorse or promote products derived from this software without
*      specific prior written permission.
*  
*  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
*  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
*  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
*  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
*  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
*  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
*  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
*  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
*  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
*  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
*/


class base91 {
	static function getEnctab() {
		return array(
			'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
			'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
			'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
			'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '!', '#', '$',
			'%', '&', '(', ')', '*', '+', ',', '.', '/', ':', ';', '<', '=',
			'>', '?', '@', '[', ']', '^', '_', '`', '{', '|', '}', '~', '"'
		);
	}

	static function getDectab() {
		return array_flip(self::getEnctab());
	}
	
	static function decode($d)
	{
		$n = null;
		$b = null;
		$o = null;
		$b91_dectab = self::getDectab();
		$l = strlen($d);
		$v = -1;
		for ($i = 0; $i < $l; ++$i) {
			$c = $b91_dectab[$d{$i}];
			if (!isset($c))
				continue;
			if ($v < 0)
				$v = $c;
			else {
				$v += $c * 91;
				$b |= $v << $n;
				$n += ($v & 8191) > 88 ? 13 : 14;
				do {
					$o .= chr($b & 255);
					$b >>= 8;
					$n -= 8;
				} while ($n > 7);
				$v = -1;
			}
		}
		if ($v + 1)
			$o .= chr(($b | $v << $n) & 255);
		return $o;
	}
	
	static function encode($d)
	{
		$n = null;
		$b = null;
		$o = null;
		$b91_enctab = self::getEnctab();
		$l = strlen($d);
		for ($i = 0; $i < $l; ++$i) {
			$b |= ord($d{$i}) << $n;
			$n += 8;
			if ($n > 13) {
				$v = $b & 8191;
				if ($v > 88) {
					$b >>= 13;
					$n -= 13;
				} else {
					$v = $b & 16383;
					$b >>= 14;
					$n -= 14;
				}
				$o .= $b91_enctab[$v % 91] . $b91_enctab[$v / 91];
			}
		}
		if ($n) {
			$o .= $b91_enctab[$b % 91];
			if ($n > 7 || $b > 90)
				$o .= $b91_enctab[$b / 91];
		}
		return $o;
	}
}
