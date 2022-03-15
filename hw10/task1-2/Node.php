<?php

class Node
{
    protected $value;
    protected Node $leftChild;
    protected Node $rightChild;
    protected ?Node $parent = null;

    public function __construct($value = '', $parent = null)
    {
        $this->value = $value;
        $this->parent = $parent;
    }

    public function getValue()
    {
        if (preg_match(Parser::NUMBER_PATTERN, $this->value)) {
            return $this->value;
        } else {
            return $this->calculate();
        }
    }

    public function getLeftChild()
    {
        return $this->leftChild;
    }

    public function getRightChild()
    {
        return $this->rightChild;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setLeftChild(Node $node)
    {
        $this->leftChild = $node;
    }

    public function setRightChild(Node $node)
    {
        $this->rightChild = $node;
    }

    public function setParent(Node $parent)
    {
        $this->parent = $parent;
    }

    protected function calculate()
    {
        $leftOperand = $this->leftChild->getValue();
        $rightOperand = $this->rightChild->getValue();
        switch ($this->value) {
            case '-':
                return $leftOperand - $rightOperand;
                break;
            case '+':
                return $leftOperand + $rightOperand;
                break;
            case '*':
                return $leftOperand * $rightOperand;
                break;
            case '/':
                return $leftOperand / $rightOperand;
                break;
            case '^':
                return pow($leftOperand, $rightOperand);
                break;
        }
    }
}
