Tom, I've managed to write a script to compare these two sets of json data but it's slooooooooooooooooow. Even in the somewhate narrow test case below it takes a few seconds, but if I run it full out (`./sort.php` with no parameters) then it takes forever!

To run in command line...

a) If which php returns `/usr/bin/php`

		./sort.php --products="data/products-test.txt" --listings="data/listings.txt" --output="data/results-test.txt"

b) Else 
		
		php sort.php --products="data/products-test.txt" --listings="data/listings.txt" --output="data/results-test.txt"

$ php