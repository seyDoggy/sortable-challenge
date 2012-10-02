#!/usr/bin/php
<?php

# error reports
error_reporting(E_ALL);

# autoload classes
function __autoload($class_name) {
	require_once 'classes/' . $class_name . '.php';
 }

# instatiate Sortable object
$run = new Sortable();

# run it
$run->sort();

?>