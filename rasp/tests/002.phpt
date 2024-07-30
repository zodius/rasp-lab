--TEST--
test1() Basic test
--EXTENSIONS--
rasp
--FILE--
<?php
$ret = test1();

var_dump($ret);
?>
--EXPECT--
The extension rasp is loaded and working!
NULL
