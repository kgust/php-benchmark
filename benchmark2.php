<?php

// test a simple array_map in the real world.
function test_array_map($data){
    return array_map(function($row){
        return array(
            'productId' => $row['id'] + 1,
            'productName' => $row['name'],
            'desc' => $row['remark']
        );
    }, $data);
}

// Another with local variable $i
function test_array_map_use_local($data){
    $i = 0;
    return array_map(function($row) use ($i) {
        $i++;
        return array(
            'productId' => $row['id'] + $i,
            'productName' => $row['name'],
            'desc' => $row['remark']
        );
    }, $data);
}

// test a simple foreach in the real world
function test_foreach($data){
    $result = array();
    foreach ($data as $row) {
        $tmp = array();
        $tmp['productId'] = $row['id'] + 1;
        $tmp['productName'] = $row['name'];
        $tmp['desc'] = $row['remark'];
        $result[] = $tmp;
    }
    return $result;
}

// Another with local variable $i
function test_foreach_use_local($data){
    $result = array();
    $i = 0;
    foreach ($data as $row) {
        $i++;
        $tmp = array();
        $tmp['productId'] = $row['id'] + $i;
        $tmp['productName'] = $row['name'];
        $tmp['desc'] = $row['remark'];
        $result[] = $tmp;
    }
    return $result;
}



$data = array_fill(0, 10000, array(
    'id' => 1,
    'name' => 'test',
    'remark' => 'ok'
));

$tests = array(
    'array_map' => array(),
    'foreach' => array(),
    'array_map_use_local' => array(),
    'foreach_use_local' => array(),
);

for ($i = 0; $i < 100; $i++){
    foreach ($tests as $testName => &$records) {
        $start = microtime(true);
        call_user_func("test_$testName", $data);
        $delta = microtime(true) - $start;
        $records[] = $delta;
    }
}

// output result:
foreach ($tests as $name => &$records) {
    printf('%.4f : %s '.PHP_EOL, 
        array_sum($records) / count($records), $name);
}
