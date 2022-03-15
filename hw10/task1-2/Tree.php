<?php

class Tree
{
    protected SplStack $stack;
    protected Node $root;

    public function __construct()
    {
        $this->stack = new SplStack;
    }

    public function buildTree(array $expression)
    {
        $currentNode = new Node;
        foreach ($expression as $item) {
            if ($item == Parser::OPEN_BRACKET) {
                $this->stack->push($currentNode);
                $currentNode->setLeftChild(new Node);
                $currentNode = $currentNode->getLeftChild();
            } else if (preg_match(Parser::NUMBER_PATTERN, $item)) {
                $currentNode->setValue($item);
                $parentNode = $this->stack->pop();
                $currentNode->setParent($parentNode);
                $currentNode = $parentNode;
            } else if (preg_match(Parser::OPERATION_PATTERN, $item)) {
                $currentNode->setValue($item);
                $currentNode->setRightChild(new Node);
                $this->stack->push($currentNode);
                $parentNode = $currentNode;
                $currentNode = $currentNode->getRightChild();
                $currentNode->setParent($parentNode);
            } else if ($item == Parser::CLOSE_BRACKET) {
                if (!$this->stack->isEmpty()) $currentNode = $this->stack->pop();
            }
            if (!$currentNode->getParent()) $this->root = $currentNode;
        }
    }

    public function calculate()
    {
        return $this->root->getValue();
    }
}
