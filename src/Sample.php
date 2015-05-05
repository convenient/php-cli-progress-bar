<?php
require_once dirname(dirname(__FILE__)) . '/vendor/autoload.php';

$arr = new SplFixedArray(rand(1, 1000));

$progressBar = new \Convenient\ProgressPrinter($arr);

foreach ($arr as $val) {
    $progressBar->printProgress();
    usleep(rand(0, 250));
}
