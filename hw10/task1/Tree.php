<?php

use Parser;
use Node;

class Tree {
    protected SplStack $stack;

    public function __construct(){
        $this->stack = new SplStack;
    }

    public function buildTree(array $expression) {
        foreach ($expression as $item) {
            $currentNode = new Node();
        }
    }
}