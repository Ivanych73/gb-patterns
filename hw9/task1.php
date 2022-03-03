<?php

function bubbleSort($array){
    for($i=0; $i<count($array); $i++){
        $count = count($array);
        for($j=$i+1; $j<$count; $j++){
            if($array[$i]>$array[$j]){
                $temp = $array[$j];
                $array[$j] = $array[$i];
                $array[$i] = $temp;
            }
        }         
    }
   return $array;
}

function shakerSort ($array) {
    $n = count($array);
    $left = 0;
    $right = $n - 1;
    do {
        for ($i = $left; $i < $right; $i++) {
            if ($array[$i] > $array[$i + 1]) {
                list($array[$i], $array[$i + 1]) = array($array[$i + 1], $array[$i]);
            }
        }
        $right -= 1;
        for ($i = $right; $i > $left; $i--) {
            if ($array[$i] < $array[$i - 1]) {
                list($array[$i], $array[$i - 1]) = array($array[$i - 1], $array[$i]);
            }
        }
        $left += 1;
    } while ($left <= $right);
    return $array;
}

function quickSort(&$arr, $low, $high) {
    $i = $low;                
    $j = $high;
    $middle = $arr[ ( $low + $high ) / 2 ];   
    do {
        while($arr[$i] < $middle) ++$i;
        while($arr[$j] > $middle) --$j;
        if($i <= $j){        
            $temp = $arr[$i];
            $arr[$i] = $arr[$j];
            $arr[$j] = $temp;
            $i++; $j--;
        }
    }
    while($i < $j);
    
    if($low < $j){
      quickSort($arr, $low, $j);
    }

    if($i < $high){
      quickSort($arr, $i, $high);
    }
}

function heapify(&$arr, $countArr, $i)
{
    $largest = $i; // Инициализируем наибольший элемент как корень
    $left = 2*$i + 1; // левый = 2*i + 1
    $right = 2*$i + 2; // правый = 2*i + 2

    // Если левый дочерний элемент больше корня
    if ($left < $countArr && $arr[$left] > $arr[$largest])
    $largest = $left;

    //Если правый дочерний элемент больше, чем самый большой элемент на данный момент
    if ($right < $countArr && $arr[$right] > $arr[$largest])
    $largest = $right;

    // Если самый большой элемент не корень
    if ($largest != $i)
    {
        $swap = $arr[$i];
        $arr[$i] = $arr[$largest];
        $arr[$largest] = $swap;

        // Рекурсивно преобразуем в двоичную кучу затронутое поддерево
        heapify($arr, $countArr, $largest);
    }
}

    //Основная функция, выполняющая пирамидальную сортировку
function heapSort(&$arr)
{
    $countArr = count($arr);
    // Построение кучи (перегруппируем массив)
    for ($i = $countArr / 2 - 1; $i >= 0; $i--)
    heapify($arr, $countArr, $i);

    //Один за другим извлекаем элементы из кучи
    for ($i = $countArr-1; $i >= 0; $i--)
    {
        // Перемещаем текущий корень в конец
        $temp = $arr[0];
        $arr[0] = $arr[$i];
        $arr[$i] = $temp;

        // вызываем процедуру heapify на уменьшенной куче
        heapify($arr, $i, 0);
    }
}



$myArray = [];

for ($i=1; $i<10000; $i++) {
    $myArray[$i] = rand(1, 1000000);
}

echo "Массив создан <br>";
$arrPHPSort = $myArray;
$start = microtime(true);

sort(($arrPHPSort));

echo "Сортировка массива встроенным методом PHP заняла ".round(microtime(true) - $start, 4).' сек. <br>';

set_time_limit(1200);

$start = microtime(true);

$arrBubbleSort = bubbleSort($myArray);

echo "Сортировка массива методом пузырьковой сортировки заняла ".round(microtime(true) - $start, 4).' сек. <br>';

$start = microtime(true);

$arrShakerSort = shakerSort($myArray);

echo "Сортировка массива методом шейкерной сортировки заняла ".round(microtime(true) - $start, 4).' сек. <br>';

$arrQuickSort = $myArray;

$start = microtime(true);

quickSort($arrQuickSort, 0, count($arrQuickSort)-1);

echo "Сортировка массива методом быстрой сортировки заняла ".round(microtime(true) - $start, 4).' сек. <br>';

$arrHeapSort = $myArray;

$start = microtime(true);

heapSort($arrHeapSort);

echo "Сортировка массива методом пирамидальной сортировки заняла ".round(microtime(true) - $start, 4).' сек. <br>';