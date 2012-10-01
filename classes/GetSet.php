<?php

# state
class GetSet
{
	public $opt;
	
	function __construct()
	{
		$this->opt = new Options();
		return true;
	}

	# state
	public function state()
	{
		# test for "-s" or "--state" settings
		static $short = "s";
		static $long = "state";

		# get testOpt
		$state = $this->opt->testOpt($this->opt->setOpt(),$short,$long);
		
		# set test state
		$state == 1 || $state === "test" ? $state = "-test" : $state = "";

		return $state;

	}

	# path
	public function file($type,$short,$long,$out)
	{
		# get testOpt
		$file = $this->opt->testOpt($this->opt->setOpt(),$short,$long);

		# set path for file
		empty($file) ? $file = "data/" . $type . $this->state() . ".txt" : $file = $file;

		if (isset($out) && $out === true) {
			define('OUTPUT_FILE', $file);
			$file = file_put_contents($file, '');
		} else {
			$file = file_get_contents($file);
			$file = explode("\n", $file);
		}

		return $file;
	}

	# products
	function products()
	{
		$type = "products";
		$short = "p";
		$long = "products";
		$out = false;
		# call GetSet
		$products = new $this();
		$products = $products->file($type,$short,$long,$out);

		return $products;
	}

	# listings
	function listings()
	{
		$type = "listings";
		$short = "l";
		$long = "listings";
		$out = false;
		# call GetSet
		$listings = new $this();
		$listings = $listings->file($type,$short,$long,$out);

		return $listings;
	}

	# results
	function results()
	{

		$type = "results";
		$short = "o";
		$long = "output";
		$out = true;
		# call GetSet
		$results = new $this();
		$results = $results->file($type,$short,$long,$out);

	}
}

?>