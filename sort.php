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

	# testOpt
	public function testOpt($opt,$short,$long)
	{
		# test for "-short" or "--long" settings
		if (isset($opt[$short])) $option = $opt[$short];
		elseif (isset($opt[$long])) $option = $opt[$long];
		else $option = "";

		return $option;
	}

	# state
	public function state()
	{
		# test for "-s" or "--state" settings
		static $short = "s";
		static $long = "state";

		# get testOpt
		$state = $this->testOpt(Options::opt(),$short,$long);
		
		# set test state
		$state == 1 || $state === "test" ? $state = "-test" : $state = "";

		# clean up
		unset($short,$long); 

		return $state;

	}

	# path
	public function file($type,$short,$long)
	{
		# get testOpt
		$full = $this->testOpt(Options::opt(),$short,$long);

		# get state

		# set path for file
		empty($full) ? $file = "data/" . $type . $this->state() . ".txt" : $file = $full;

		$file = file_get_contents($file);

		return $file;
	}

	# products
	function products()
	{
		$type = "products";
		$short = "p";
		$long = "products";
		# call GetSet
		$products = new $this(Options::opt());
		$products = $products->file($type,$short,$long);

		// $products = json_decode($products,1);

		return $products;
	}

	# listings
	function listings()
	{
		$type = "listings";
		$short = "l";
		$long = "listings";
		# call GetSet
		$listings = new $this(Options::opt());
		$listings = $listings->file($type,$short,$long);

//		$listings = explode("\n", $listings);
//		foreach($listings as &$l) $l = json_decode($l,1);

		return $listings;

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
	
	
	
}


$run = new GetSet();

echo $run->listings();

?>