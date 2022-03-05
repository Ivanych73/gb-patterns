<?php

class Parser {
    const NUMBER_PATTERN = "/[0-9a-zA-Z\.]/";
    const OPERATION_PATTERN = "/[\+\-\*\/\^]/";
    const OPEN_BRACKET = "(";
    const CLOSE_BRACKET = ")";

    protected function getNumbersFromDigits($expression) {
        $arr = str_split($expression);
        $res = [];
        $currentNumber = "";
        foreach ($arr as $value) {
            if (preg_match(self::NUMBER_PATTERN, $value)) {
                $currentNumber .= $value;
            }
            else if (preg_match(self::OPERATION_PATTERN, $value)
                || $value == self::OPEN_BRACKET
                || $value == self::CLOSE_BRACKET
                ) {
                if ($currentNumber != '') {
                    $res[] = (float)$currentNumber;
                    $currentNumber = "";
                }
                $res[] = $value;
            }
        }
        if ($currentNumber != '') $res[] = (float)$currentNumber;
        return $res;
    }

    public function parse(string $expression = "33.2*7+41+50") {
        $res = self::getNumbersFromDigits($expression);
        return $res;
    }
}