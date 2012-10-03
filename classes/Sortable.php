<?php 
/*

CLASS: Sortable

This is where the matching goes on.

*/
class Sortable
{
	/*

	Define all the variables and instantiate 
	some object goodness when Sortable is 
	instantiated.

	*/
	public $GetSet;
	public $Stringsets;
	public $output;
	public $products;
	public $listings;
	public $results;
	
	function __construct()
	{
		$this->GetSet = new GetSet();
		$this->Stringsets = new Stringsets();
		$this->output = array();
		$this->products = $this->GetSet->products();
		$this->listings = $this->GetSet->listings();
		$this->results = $this->GetSet->results();
	}


	/*

	METHOD: sort

	This is it. This is the method that 
	does all the work. It's really slow 
	right now given the massive size of 
	the files. I have no other ideas right 
	now though.

	*/
	public function sort()
	{
		# turn each line in the listings into an array
		foreach($this->listings as &$l) $l = json_decode($l, true);
		
		# iterate through the products file
		foreach($this->products as $p) {
			# turn each line in the products into an array
			$p = json_decode($p, true);

			# initialize findings in output file
			$this->output[$p['product_name']] = array(
				'product_name' => $p['product_name'],
				'listings' => array()
			);

			/* Example of a product
			{
			"product_name":"Sony_Cyber-shot_DSC-W310",
			"manufacturer":"Sony",
			"model":"DSC-W310",
			"family":"Cyber-shot",
			"announced-date":"2010-01-06T19:00:00.000-05:00"
			}

			Example of a listing
			{
			"title":"LED Flash Macro Ring Light (48 X LED) with 6 Adapter Rings for For Canon/Sony/Nikon/Sigma Lenses",
			"manufacturer":"Neewer Electronics Accessories",
			"currency":"CAD",
			"price":"35.99"
			}
			*/

			# if manufacture, family and model aren't empty
			if (!empty($p['product_name'])
				&& !empty($p['manufacturer'])
				&& !empty($p['model'])) {
				
				$product_name = $this->Stringsets->regexify($p['product_name']);
				$manufacturer = $this->Stringsets->regexify($p['manufacturer']);
				$model = $this->Stringsets->regexify($p['model']);

				# message
				echo "Looking for matches to \"" . $p['product_name'] . "\"...\n";

				
				# iterate through each line of the listings file
				# hardcore pass
				foreach($this->listings as $i => $l) {

					if (preg_match($manufacturer, $l['manufacturer'])
						&& preg_match($model, $l['title'])
						&& (preg_match($product_name, $l['title'])
							|| preg_match($manufacturer, $l['title']))) {
						
						# message						
						echo "	Line " . $i . ": \"" . $l['title'] . "\"\n";
						
						# output results
						$this->output[$p['product_name']]['listings'][] = $l;

						# unset line to skip on next loop (if applicable)
						unset($this->listings[$i]);
					}
				}
			}
		}

		// write output
		foreach($this->output as $line) file_put_contents(OUTPUT_FILE, json_encode($line)."\n", FILE_APPEND);

		exit(0);
	}
}
?>