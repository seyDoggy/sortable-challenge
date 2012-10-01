<?php

# Stringsets
class Stringsets
{

	// scrub strings
	function regexify($string) {
		return preg_replace('/([a-z])(\d)/i', '$1[^a-z\d]*$2',
		       preg_replace('/(\d)([a-z])/i', '$1[^a-z\d]*$2',
		       preg_replace('/[^a-z\d]+/i', '[^a-z\d]*',
		       $string)));
	}

	// string with word boundaries
	function makeRegex($string) {
		return '/\b' . $this->regexify($string) . '\b/i';
	}

	// string without word boundaries
	function makeRegexNoWord($string) {
		return '/' . $this->regexify($string) .'/i';
	}
}

?>