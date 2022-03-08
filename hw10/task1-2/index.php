<?php

spl_autoload_register(function ($class) {
    include $class . '.php';
});

$parser1 = new Parser;

$newExpression = "33.2*(7+41)+50";

$parsedExpression = $parser1->run($newExpression);

$myTree = new Tree;
$myTree->buildTree($parsedExpression);
echo "Результат выражения $newExpression равен ";
echo $myTree->calculate();
