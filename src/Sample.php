<?php
require_once 'vendor/autoload.php';

$arr = new SplFixedArray(rand(1, 1000));

$progressBar = new \Convenient\ProgressPrinter($arr);

foreach ($arr as $val) {
    $progressBar->printProgress();
    usleep(rand(0, 250));
}
