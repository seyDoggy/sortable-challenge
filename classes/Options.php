<?php

# Options
class Options
{
	# setOpt
	function setOpt()
	{
		$shortopts  = "s::"; // optional state - boolean or test (true) - defaults to false
		$shortopts  .= "p::"; // optional products path - defaults to data/products.txt
		$shortopts  .= "l::"; // optional listings path - defaults to data/listings.txt
		$shortopts  .= "o::"; // optional output path - defaults to data/listings.txt

		$longopts  = array(
			"state::", // optional state - boolean or test (true) - defaults to false
			"products::", // optional products path - defaults to data/products.txt
			"listings::", // optional listings path - defaults to data/listings.txt
			"output::", // optional listings path - defaults to data/listings.txt
		);

		return $options = getopt($shortopts, $longopts);
	}

	# testOpt
	function testOpt($opt,$short,$long)
	{
		# test for "-short" or "--long" settings
		if (isset($opt[$short])) $option = $opt[$short];
		elseif (isset($opt[$long])) $option = $opt[$long];
		else $option = "";

		return $option;
	}

}

?>