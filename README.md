# php-cli-progress-bar
An itty bitty, super simple, 2 line progress bar for PHP command line applications.

Takes two parameters

1. The size of your `Traversable` or - if you're lazy - the `Traversable` itself.
2. How many characters across you want your progress bar to be.

## Example

### Passing the size of the Traversable

```
<?php
require_once '/vendor/autoload.php';

$progressBar = new \Convenient\ProgressPrinter(500);

for ($i=0; $i<500; $i++) {
    $progressBar->printProgress();
}
```

### Passing in the Traversable

```
<?php
require_once '/vendor/autoload.php';

$arr = new SplFixedArray(500));

$progressBar = new \Convenient\ProgressPrinter($arr);

foreach ($arr as $val) {
    $progressBar->printProgress();
}
```

### Change the size of the progress bar

```
<?php
require_once '/vendor/autoload.php';

$arr = new SplFixedArray(500));

$progressBar = new \Convenient\ProgressPrinter(500, 100);

for ($i=0; $i<500; $i++) {
    $progressBar->printProgress();
}
```
