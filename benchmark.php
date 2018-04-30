<?php
/**
 * From: https://stackoverflow.com/questions/18144782/performance-of-foreach-array-map-with-lambda-and-array-map-with-static-function#26527704
 * Author: FGM
 */

function lap($func) {
    $t0 = microtime(1);
    $numbers = range(0, 1000000);
    $ret = $func($numbers);
    $t1 = microtime(1);
    return array($t1 - $t0, $ret);
}

function useForeach($numbers) {
    $result = array();
    foreach ($numbers as $number) {
        $result[] = $number * 10;
    }
    return $result;
}

function useMapClosure($numbers) {
    return array_map(function($number) {
        return $number * 10;
    }, $numbers);
}

function useMapClosureAlt($numbers) {
  $closure = function($number) {
    return $number * 10;
  };

  return array_map($closure, $numbers);
}

function _tenTimes($number) {
    return $number * 10;
}

function useMapNamed($numbers) {
    return array_map('_tenTimes', $numbers);
}

function useMapClosureI($numbers) {
    $i = 10;
    return array_map(function($number) use ($i) {
        $result[] = $number * $i++;
    }, $numbers);
}

function useForeachI($numbers) {
    $result = [];
    $i = 10;
    foreach ($numbers as $number) {
        $result[] = $number * $i++;
    }
    return $result;
}

$callbacks = [
    'Foreach',
    'ForeachI',
    'MapClosure',
    'MapClosureAlt',
    'MapClosureI',
    'MapNamed',
];

foreach ($callbacks as $callback) {
    list($delay,) = lap("use$callback");
    echo "$callback: $delay\n";
}
