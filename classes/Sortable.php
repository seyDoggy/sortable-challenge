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
		foreach($this->products as $j => &$p) {
			$p = json_decode($p, true);// decode json string

			// initialize product in output
			$this->output[$p['product_name']] = array(
				'product_name' => $p['product_name'],
				'listings' => array()
			);

			// search for ideal match first - manufacturer + family + full model
			if (empty($p['manufacturer']) || empty($p['model']) || empty($p['family'])) continue;

			$manufacturer = $this->Stringsets->makeRegex($p['manufacturer']);
			$model = $this->Stringsets->makeRegex($p['model']);
			$family = $this->Stringsets->makeRegex($p['family']);

			foreach($this->listings as $i => $l) {
				if (!preg_match($manufacturer, $l['manufacturer']) || !preg_match($model, $l['title']) || !preg_match($family, $l['title'])) continue;

				$this->output[$p['product_name']]['listings'][] = $l;// add match to output
				unset($this->listings[$i]);// remove matched listing from future searches
			}
		}

		// 2nd pass - look for manufacturer + full model from listings that haven't been matched yet
		foreach($this->products as $p) {
			if (empty($p['manufacturer']) || empty($p['model'])) continue;

			$manufacturer = $this->Stringsets->makeRegex($p['manufacturer']);
			$model = $this->Stringsets->makeRegex($p['model']);

			foreach($this->listings as $i => $l) {
				if (!preg_match($manufacturer, $l['manufacturer']) || !preg_match($model, $l['title'])) continue;

				$this->output[$p['product_name']]['listings'][] = $l;
				unset($this->listings[$i]);
			}
		}

		// 3rd pass - look for partial models - e.g. model is DSC123 but listing has DSC123S
		// skipped if model is only numbers or only letters (too general - many false positives)
		foreach($this->products as $p) {
			if (empty($p['manufacturer']) || empty($p['model']) || is_numeric($p['model']) || !preg_match('/\d/', $p['model'])) continue;

			$manufacturer = $this->Stringsets->makeRegex($p['manufacturer']);
			$model = $this->Stringsets->makeRegexNoWord($p['model']);

			foreach($this->listings as $i => $l) {
				if (!preg_match($manufacturer, $l['manufacturer']) || !preg_match($model, $l['title'])) continue;

				$this->output[$p['product_name']]['listings'][] = $l;
				unset($this->listings[$i]);
			}
		}

		// write output
		foreach($this->output as $line) file_put_contents(OUTPUT_FILE, json_encode($line)."\n", FILE_APPEND);

		exit(0);
	}

}
?>