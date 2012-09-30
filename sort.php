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

# state
class GetSet
{
	public $opt;
	
	function __construct($opt)
	{
		$this->opt = $opt;
		return true;
	}

	# state
	function state($opt)
	{
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
}

# Sortable
class Sortable
{

	# output
	function output()
	{

		isset($argv[4]) ? $outputFile = $argv[4] : $productFile = "data/output" . $a . ".txt";
		$output = array();
		file_put_contents($outputFile, '');

	}
	
	function products()
	{
		# call GetSet
		$path = new GetSet(Options::opt());

		# test for "-p" or "--products" settings
		if (isset($opt["p"])) $full = $opt["p"];
		elseif (isset($opt["products"])) $full = $opt["products"];
		else $full = "";

		# set path for products file
		empty($full) ? $products = "data/products" . $path->state($path->opt) . ".txt" : $products = $path;

		# get product file
		$products = file_get_contents($products);
		// $products = json_decode($products,1);

		# cleanup
		unset($full,$path);

		return $products;
	}

	# listings
	function listings()
	{
		# call GetSet
		$path = new GetSet(Options::opt());

		# test for "-l" or "--listings" settings
		if (isset($opt["l"])) $full = $opt["l"];
		elseif (isset($opt["listings"])) $full = $opt["listings"];
		else $full = "";

		# set path for listings file
		empty($full) ? $listings = "data/listings" . $path->state($path->opt) . ".txt" : $listings = $path;


		$listings = file_get_contents($listings);
		$listings = explode("\n", $listings);
		foreach($listings as &$l) $l = json_decode($l,1);

		# cleanup
		unset($full,$path);

		return $listings;

	}
	
}


$run = new Sortable();

echo $run->products();

?>