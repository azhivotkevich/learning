<?php
/*error_reporting(E_ALL);

use components\App;
require_once __DIR__ . '/vendor/autoload.php';
App::init(require_once __DIR__ . '/config/web.php');*/



var_dump(3**3);


$i = 0;
function power($num, $power) {
    global $i;
    $i++;
    if ($power === 0) {
        return 1;
    }

    if ($power === 1) {
        return $num;
    }

    if ($power % 2 == 0) {
        $m = power($num, $power / 2);
        return $m * $m;
    }

    return $num * power($num, $power-1);
}
echo PHP_EOL;
var_dump(power(3, 10));
echo PHP_EOL;
var_dump($i);