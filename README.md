# Sortable Challenge

I wrote this in OOP PHP a) because I wanted to write a nice object oriented program in something other than JavaScript for a change (which is arguably not all that object oriented at the best of times), b) I wanted to write something that required no dependencies (otherwise node.js would have been a blast to mess around in) and c) because my Python skills are less then ninja-like so writing full blown OOP Python, while as enjoyable as the learning experience would be, would take me longer the the few scant hours I could commit to this little diddy.

What I put together started out pretty cool, pretty usable and pretty clean. It's a nice little script with optional parameters and such. Nearly anything that got done twice was either thrown into a class or became the method of an existing class. I mean truth be told my formal training in software design is limited to a few PHP course I took so I couldn't really tell you the difference between a Singleton and a Multiton, but I know how to create things that are usable and I aim for scalability as best as I can foresee. And I can Google the heck out of any problem.

So anyhow, like I said, it starts out pretty nice in the test routines running smaller sets of data, but when you run the full blown data sets things get sloooooooooow. And while it pains me to push it out in this state, I don't have a lot of time to mess with it right now. It works, it's enjoyable to use, it's nice to look at, but it's slow.

## Usage

1. Clone the repo, cd to folder containing sort.php
1. To run the default, full on mongolicious data sets:

	```bash
	# assumes your php is installed at /usr/bin/php
	$ ./sort.php

	# otherwise
	$ php sort.php
	```
1. 