<?php

$n = 600851475143;

function getMaxPrimeDivider($n)
{
    for ($divider = floor(sqrt($n)); $divider > 1; $divider--) {
        if ($n % $divider == 0 && is_prime($divider)) return $divider;
    }
}

function is_prime($number)
{
    for ($x = 2; $x <= sqrt($number); $x++) {
        if ($number % $x == 0) {
            return false;
        }
    }
    return true;
}

echo "Наибольшим простым делителем числа $n является " . getMaxPrimeDivider($n);
