<?php

/**
 * Store Lab Install Main
 *
 * Esse script tem como objetive automatizar a instalalção das lojas
 * Atualmente esse script consegue instalar somente lojas com dumps com nomeDaLoja.com.br.sql e gitlab
 * para instalar lojas que não seguem essa configuração, favor utilizar o storeBasicInstall.php
 *
 */

include 'functions.php';

echo 'php script é o caminho!' . PHP_EOL;
try {

    shell_exec('cp ../hta/local.xml ./app/etc/');
    shell_exec('cp ../hta/htaccess ./.htaccess');

    shell_exec('mkdir var/');

    $dbsPath = '/home/rodolfo/dev/dbs/';
    $pv = "pv $dbsPath";

    $setPass = changeXmlCdataValue('app/etc/local.xml', 'password', 'root');

    if ($setPass) {
        $storeDir = (getCurrentDir()) ? getCurrentDir() : false;
        $storeDb = ($storeDir) ? str_replace('-', '', $storeDir) : false;

        $setDB = changeXmlCdataValue('app/etc/local.xml', 'dbname', $storeDb);

        if ($storeDir && $storeDb) {

            $files = dirFilesList($dbsPath);
            $zipDb = findStoreDumpFile($files, $storeDb);

            if ($zipDb) {
                shell_exec('mysql -u root -proot -e "create database ' . $storeDb . '";');
                if (shell_exec("gunzip $dbsPath$zipDb")) {
                    return 'cant get the name folder';

                    $unzipDb = substr($zipDb, 0, strlen($zipDb) - 3);

                    shell_exec("mv $unzipDb $storeDb.com.br.sql");
                    shell_exec("$pv$storeDb.com.br.sql | mysql -u root -proot $storeDb");

                    echo shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.admin_user SET password = md5('admin') WHERE email = 'suporte@bis2bis.com.br'\";");
                    echo shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 0 WHERE config_id = 669\";");
                    echo shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 'http://localhost/$storeDir/' WHERE path = 'web/unsecure/base_url' OR path = 'web/secure/base_url'\";");

                    shell_exec('compass compile');
                    echo 'mg';
                }else{
                    echo 'erro eu extrair o banco';
                }

            } else {
                return 'dump error';
            }

        } else {
            return 'cant get the name folder';
        }
    } else {
        return 'error editing the local.xml';
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
