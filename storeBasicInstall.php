<?php

/**
 * Store Install Main
 *
 * Esse script tem como objetive automatizar a instalalção das lojas que não estão previstas no storeInstall.php
 */

include 'functions.php';

echo 'php script é o caminho!' . PHP_EOL;

shell_exec('cp ../../hta/local.xml ./app/etc/');
shell_exec('cp ../../hta/htaccess ./.htaccess');

shell_exec('mkdir var/');

// shell_exec('chmod 777 var/ -R');

$setPass = changeXmlCdataValue('app/etc/local.xml', 'password', 'root');

if ($setPass) {
    $pv = 'pv ~/dev/dbs/';
    $storeDir = (getCurrentDir()) ? getCurrentDir() : false;
    $storeDb = ($storeDir) ? str_replace('-', '', $storeDir) : false;

    $setDB = changeXmlCdataValue('app/etc/local.xml', 'dbname', $storeDb);

} else {
    return 'error editing the local.xml';
}
