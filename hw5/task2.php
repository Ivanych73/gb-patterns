<?php

class CircleAreaLib
{
   public function getCircleArea(float $diagonal)
   {
       $area = (M_PI * $diagonal**2)/4;

       return $area;
   }
}

class SquareAreaLib
{
   public function getSquareArea(float $diagonal)
   {
       $area = ($diagonal**2)/2;
       return $area;
   }
}

interface ISquare
{
function squareArea(int $sideSquare);
}

interface ICircle
{
function circleArea(int $circumference);
}

class CircleAdapter implements ICircle {
    private $circleAreaLib;

    public function __construct(){
        $this->circleAreaLib = new CircleAreaLib;
    }

    public function circleArea(int $circumference) {
        $diagonal = $circumference/M_PI;
        return $this->circleAreaLib->getCircleArea($diagonal);
    }
}

class SquareAdapter implements ISquare {
    private $squareAreaLib;

    public function __construct(){
        $this->squareAreaLib = new SquareAreaLib;
    }

    public function squareArea(int $sideSquare) {
        $diagonal = sqrt(2*($sideSquare**2));
        return $this->squareAreaLib->getSquareArea($diagonal);
    }
}

$square = new SquareAdapter();
echo "Площадь квадрата со стороной 8 равна ".$square->squareArea(8);

$circle = new CircleAdapter();
echo "Площадь круга с длиной окружности 25 равна ".$circle->circleArea(25);