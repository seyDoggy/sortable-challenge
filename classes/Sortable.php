<?php 
# Sortable
class Sortable
{
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

	public function sort()
	{
		// decode json string for each lisitng
		foreach($this->listings as &$l) $l = json_decode($l, true);
		
		// read in products
		foreach($this->products as $p) {
			// decode json string for each product
			$p = json_decode($p, true);

			// initialize product in output
			$this->output[$p['product_name']] = array(
				'product_name' => $p['product_name'],
				'listings' => array()
			);

			/* {
			"product_name":"Sony_Cyber-shot_DSC-W310",
			"manufacturer":"Sony",
			"model":"DSC-W310",
			"family":"Cyber-shot",
			"announced-date":"2010-01-06T19:00:00.000-05:00"
			} */

			// Hardcore
			if (!empty($p['manufacturer'])
				&& !empty($p['family'])
				&& !empty($p['model'])) {
				
				$manufacturer = $this->Stringsets->makeRegex($p['manufacturer']);
				$model = $this->Stringsets->makeRegex($p['model']);
				$family = $this->Stringsets->makeRegex($p['family']);

				foreach($this->listings as $i => $l) {
					if (preg_match($manufacturer, $l['title'])
						&& preg_match($family, $l['title'])
						&& preg_match($model, $l['title'])) {

						$this->output[$p['product_name']]['listings'][] = $l;// add match to output
						// unset($this->listings[$i]);// remove matched listing from future searches
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