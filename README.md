# Sortable Challenge

I wrote this in OOP PHP because... 

a) I wanted to write a nice object oriented program in something other than JavaScript for a change (which is arguably not all that object oriented at the best of times),    
b) I wanted to write something that required no dependencies and    
c) my Python skills are less then ninja-like so writing full blown OOP Python, while as enjoyable as the learning experience would be, would take me longer the the few scant hours I could commit to this little diddy.

What I put together starts out pretty cool, pretty usable and pretty clean. It's a nice little script with optional parameters and such. Anything that got written/used/thought of twice was either thrown into a class or became a method of an existing class. Truth be told my formal training in software design is limited to a few PHP course I took a few years back, so I couldn't really tell you the difference between a Singleton and a Multiton, but I'm a pretty logical guy and I can Google the heck out of any problem.

So anyhow, like I said, it starts out pretty nice in the test routines running smaller sets of data, but when you run the full blown data sets things get sloooooooooow. And while it pains me to push it out in this state, I don't have a lot of time to mess with it right now. It works, it's easy to use, it's nice to look at, but it's slow. So we'll call it a beta. ;)

## Usage

1. Clone the repo, cd to the folder containing sort.php
1. To run the default, full on mongolicious data sets, in a command prompt:

	```bash
	# assumes your php is installed at /usr/bin/php
	$ ./sort.php

	# otherwise...
	$ php sort.php
	```
1. To run files of your choosing, use one or more of the following parameters:

	1. `-p` or `--products` flag with a path:

		```bash
		# with the -p flag
		$ ./sort.php -psome/path/products.txt

		# with the --products flag
		$ ./sort.php --products="some/path/products.txt"
		```

	1.`-l` or `--listings` flag with a path:

		```bash
		# with the -l flag
		$ ./sort.php -lsome/path/listings.txt

		# with the --listings flag
		$ ./sort.php --listings="some/path/listings.txt"
		```

	1. `-o` or `--output` flag with a path:

		```bash
		# with the -o flag
		$ ./sort.php -osome/path/results.txt

		# with the --output flag
		$ ./sort.php --output="some/path/results.txt"
		```
	1. Or any combination of the above:

		```bash
		$ ./sort.php -psome/path/products.txt --listings="some/path/listings.txt" -osome/path/results.txt
		```
1. There is also a "sub routine" (not really) to run the test files included in the data folder. To run those, use the state flag (`-s` or `--state`):

	```bash
	# using the -s flag
	$ ./sort.php -stest

	# using the --state flag
	$ ./sort.php --state="test"

	# which is just shorthand for
	$ ./sort.php --products="data/products-test.txt" --listings="data/listings-test.txt" --output="results-test.txt"


