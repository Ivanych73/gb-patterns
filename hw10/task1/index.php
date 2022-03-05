<?php

require_once('Parser.php');

$parser = new Parser;

$myArray = $parser->parse();

var_dump($myArray);