<?php

/*

CLASS: GetSet

This class gets input files and sets output files
by analyzing the options passed in on the command
line. 

*/
class GetSet
{
	/*

	Define the options variable and instantiate
	a new Options object when a new GetSet object
	is instantiated.

	*/
	public $opt;
	
	function __construct()
	{
		$this->opt = new Options();
		return true;
	}

	/*

	METHOD: state

	This method is for test runs only.
	It looks for the use of -s or 
	--state flags and returns a value 
	to be inserted into the file string.

	It's only useful if using test files.

	*/
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

	/*

	METHOD: file

	This method either gets the input files
	or initiates the output file based on 
	the passed in parameters.

	*/
	public function file($type,$short,$long,$out)
	{
		# get testOpt
		$file = $this->opt->testOpt($this->opt->setOpt(),$short,$long);

		# set path for file
		empty($file) ? $file = "data/" . $type . $this->state() . ".txt" : $file = $file;

		# import or export
		if (isset($out) && $out === true) {
			define('OUTPUT_FILE', $file);
			$file = file_put_contents($file, '');
		} else {
			$file = file_get_contents($file);
			$file = explode("\n", $file);
		}

		return $file;
	}

	/*

	METHOD: products

	This method sets up some parameters
	for retrieving the products file.

	*/
	function products()
	{
		$type = "products";
		$short = "p";
		$long = "products";
		$out = false;

		return $this->file($type,$short,$long,$out);;
	}

	/*

	METHOD: listings

	This method sets up some parameters
	for retrieving the listings file.

	*/
	function listings()
	{
		$type = "listings";
		$short = "l";
		$long = "listings";
		$out = false;

		return $this->file($type,$short,$long,$out);
	}

	/*

	METHOD: results

	This method sets up some parameters
	for outputting the products file.

	*/
	function results()
	{

		$type = "results";
		$short = "o";
		$long = "output";
		$out = true;

		return $this->file($type,$short,$long,$out);

	}
}

?>