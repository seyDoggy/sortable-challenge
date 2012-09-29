#!/usr/bin/php
<?php

error_reporting(E_ALL);

# Options
class Options
{
	
	function opt()
	{
		$shortopts  = "s::"; // optional state - boolean or test (true) - defaults to false
		$shortopts  .= "p::"; // optional products path - defaults to data/products.txt
		$shortopts  .= "l::"; // optional listings path - defaults to data/listings.txt

		$longopts  = array(
			"state::", // optional state - boolean or test (true) - defaults to false
			"products::", // optional products path - defaults to data/products.txt
			"listings::", // optional listings path - defaults to data/listings.txt
		);

		return $options = getopt($shortopts, $longopts);
	}

}

# Stringsets
class Stringsets
{
	
	// scrub strings
	function prepareRegex($a) {
		return preg_replace('/([a-z])(\d)/i', '$1[^a-z\d]*$2',
		       preg_replace('/(\d)([a-z])/i', '$1[^a-z\d]*$2',
		       preg_replace('/[^a-z\d]+/i', '[^a-z\d]*',
		       $a)));
	}

	// make regex string with word boundaries
	function makeRegex($a) {
		return '/\b'.prepareRegex($a).'\b/i';
	}

	// make regex string without word boundaries
	function makeRegexNoWord($a) {
		return '/'.prepareRegex($a).'/i';
	}
}


# Sortable
class Sortable
{

	# state
	function state()
	{
		# call options
		$opt = Options::opt();

		# test for "-s" or "--state" settings
		if (isset($opt["s"])) $state = $opt["s"];
		elseif (isset($opt["state"])) $state = $opt["state"];
		else $state = "";

		# cleanup
		unset($opt);

		# set test state
		$state == 1 || $state === "test" ? $state = "-test" : $state = ""; 

		return $state;

	}

	# output
	function output()
	{

		isset($argv[4]) ? $outputFile = $argv[4] : $productFile = "data/output" . $a . ".txt";
		$output = array();
		file_put_contents($outputFile, '');

	}
	
	function products()
	{
		# call options
		$opt = Options::opt();

		# call state
		$state = Sortable::state();

		# test for "-p" or "--products" settings
		if (isset($opt["p"])) $path = $opt["p"];
		elseif (isset($opt["products"])) $path = $opt["products"];
		else $path = "";

		# set path for products file
		empty($path) ? $products = "data/products" . $state . ".txt" : $products = $path;

		# get product file
		$products = file_get_contents($products);
		// $products = json_decode($products,1);

		# cleanup
		unset($opt,$state,$path);

		return $products;
	}

	# listings
	function listings()
	{
		# call options
		$opt = Options::opt();

		# call state
		$state = Sortable::state();

		# test for "-l" or "--listings" settings
		if (isset($opt["l"])) $path = $opt["l"];
		elseif (isset($opt["listings"])) $path = $opt["listings"];
		else $path = "";

		# set path for listings file
		empty($path) ? $listings = "data/listings" . $state . ".txt" : $listings = $path;


		$listings = file_get_contents($listings);
		$listings = explode("\n", $listings);
		foreach($listings as &$l) $l = json_decode($l,1);

		# cleanup
		unset($opt,$state,$path);

		return $listings;

	}
	
}


$run = new Sortable();

echo $run->listings();

?>