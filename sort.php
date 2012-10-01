#!/usr/bin/php
<?php

# error reports
error_reporting(E_ALL);

# autoload classes
function __autoload($class_name) {
	require_once 'classes/' . $class_name . '.php';
 }

$run = new Sortable();

echo $run->sort();

?>