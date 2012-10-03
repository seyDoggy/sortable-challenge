<?php

/*

CLASS: Stringsets

This class messes around with
perfectly good strings.

*/
class Stringsets
{

	/*

	METHOD: regexify

	This method takes a string (like an array value)
	and converts it into a regex search pattern, that 
	ignores all non-alphanumerics. For
	example:

	Olympus_Stylus-Tough 8010

	becomes:

	/\bOlympus[^a-z\d]*Stylus[^a-z\d]*Tough[^a-z\d]*8010\b/i

	*/
	function regexify($string) {
		return 
			'/\b' . 
			preg_replace(
				'/([a-z])(\d)/i',
				'$1[^a-z\d]*$2',
				preg_replace(
					'/(\d)([a-z])/i',
					'$1[^a-z\d]*$2',
					preg_replace(
						'/[^a-z\d]+/i',
						'[^a-z\d]*',
						$string
					)
				)
			)
			. '\b/i';
	}
}

?>