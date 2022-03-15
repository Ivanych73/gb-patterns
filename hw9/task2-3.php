<?php

function getRandomSortedArray()
{
    $myArray = [];
    for ($i=1; $i<10000; $i++) {
        $myArray[$i] = rand(1, 1000000);
    }
    sort($myArray);
    return $myArray;
}

function deleteFromArray(array &$source, array $found, int $count) :void
{
    if (count($found)) {
        echo "Искомый(е) элемент(ы) найден(ы) за $count шагов <br>";
        foreach($found as $index) unset($source[$index]);
        echo "Найденный(е) элемент(ы) успешно удален(ы) из массива! <br>";
    }else echo "Искомый(е) элемент(ы) не найден(ы) <br>";
}

function getDoubles($haystack, $currentIndex, $currentValue){
    $doubles = [];
    $doubles[] = $currentIndex;
    $i = $currentIndex +1;
    while($haystack[$i] == $currentValue && $i < count($haystack)) {
        $doubles[] = $i;
        $i++;
    }
    $i = $currentIndex -1;
    while($haystack[$i] == $currentValue && $i > 0) {
        $doubles[] = $i;
        $i--;
    }
    return $doubles;
}

function linearSearch (array $myArray, int $num) {
    $count = count($myArray);
    $arrFoundIndicies = [];
    for ($i=0; $i < $count; $i++) {
        if ($myArray[$i] == $num) $arrFoundIndicies[] = $i;
        elseif ($myArray[$i] > $num) break;
    }
    return ['found' => $arrFoundIndicies, 'count' => $i];
}

function binarySearch ($myArray, $num) {

    $left = 0;
    $right = count($myArray) - 1;
    $arrFoundIndicies = [];
    $count = 0;
    while ($left <= $right) {    
        $middle = floor(($right + $left)/2);
        if ($myArray[$middle] == $num) {
            $arrFoundIndicies = getDoubles($myArray, $middle, $num);
            break;
        }        
        elseif ($myArray[$middle] > $num) {
            $right = $middle - 1;
        }
        elseif ($myArray[$middle] < $num) {
            $left = $middle + 1;
        }
        $count++;
    }
    return ['found' => $arrFoundIndicies, 'count' => $count];
}

function interpolationSearch($myArray, $num)
{
    $start = 0;
    $last = count($myArray) - 1;
    $arrFoundIndicies = [];
    $count = 0;

    while (($start <= $last) && ($num >= $myArray[$start]) && ($num <= $myArray[$last])) {

        $pos = floor($start + ((($last - $start) / ($myArray[$last] - $myArray[$start])) * ($num - $myArray[$start])));
        if ($myArray[$pos] == $num) {
            $arrFoundIndicies = getDoubles($myArray, $pos, $num);
            break;
        }

        if ($myArray[$pos] < $num) {
            $start = $pos + 1;
        }

        else {
            $last = $pos - 1;
        }
        $count++;
    }
    return ['found' => $arrFoundIndicies, 'count' => $count];
}

$randomIndex = rand(1, 10000);

echo "Начинаем линейный поиск <br>";
$myArray = getRandomSortedArray();
$res = linearSearch($myArray, $myArray[$randomIndex]);
deleteFromArray($myArray, $res['found'], $res['count']);

echo "Начинаем бинарный поиск <br>";
$myArray = getRandomSortedArray();
$res = binarySearch($myArray, $myArray[$randomIndex]);
deleteFromArray($myArray, $res['found'], $res['count']);

echo "Начинаем интерполяционный поиск <br>";
$myArray = getRandomSortedArray();
$res = interpolationSearch($myArray, $myArray[$randomIndex]);
deleteFromArray($myArray, $res['found'], $res['count']);