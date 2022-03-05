<?php

class Node {
    protected $value;
    protected Node $leftChild;
    protected Node $rightChild;
    protected Node $parent;

    // public function __construct(Node $parent, $value)
    // {
    //     $this->parent = $parent;
    //     $this->value = $value;
    // }
    
    public function getValue() {
        return $this->value;
    }

    public function getLeftChild() {
        return $this->leftChild;
    }

    public function getRightChild() {
        return $this->getRightChild;
    }

    public function getParent() {
        return $this->parent;
    }

    public function setLeftChild(Node $node) {
        $this->leftChild = $node;
    }

    public function setRightChild(Node $node) {
        $this->rightChild = $node;
    }    

    public function calculate() {

    }
}