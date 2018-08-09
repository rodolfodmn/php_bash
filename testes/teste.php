<?php
include '/home/rodolfo/dev/php_bash/functions.php';

echo $storeDir = (getCurrentDir()) ? getCurrentDir() : false;
echo PHP_EOL;
echo $storeDb = ($storeDir) ? str_replace('-', '', $storeDir) : false;
echo PHP_EOL;
echo var_dump(getIsBis2Bis($storeDb));
echo PHP_EOL;
