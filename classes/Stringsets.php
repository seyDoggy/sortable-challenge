<?php

/*

CLASS: Stringsets

This class manipulates the 
strings to make them usable 
while matching.

*/
class Stringsets
{

	function regexify($string) {
		return preg_replace('/([a-z])(\d)/i', '$1[^a-z\d]*$2',
		       preg_replace('/(\d)([a-z])/i', '$1[^a-z\d]*$2',
		       preg_replace('/[^a-z\d]+/i', '[^a-z\d]*',
		       $string)));
	}

	function makeRegex($string) {
		return '/\b' . $this->regexify($string) . '\b/i';
	}
}

?>