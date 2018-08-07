<?php
include 'functions.php';

echo 'php script é o caminho!'.PHP_EOL;

shell_exec('cp ../hta/local.xml ./app/etc/');
shell_exec('cp ../hta/htaccess ./.htaccess');

shell_exec('mkdir var/');
//// shell_exec('chmod 777 var/ -R');

$setPass = changeXmlCdataValue('app/etc/local.xml', 'password', 'root');

if ($setPass) {
    $storeDir = (getCurrentDir()) ? getCurrentDir() : false;
    $storeDb = ($storeDir) ? str_replace('-', '', $storeDir) : false;

    $setDB = changeXmlCdataValue('app/etc/local.xml', 'dbname', $storeDb);

    if ($storeDir && $storeDb) {

        if (file_exists("pv ../../dbs/$storeDb.com.br.sql"))
            $dump = "pv ../../dbs/$storeDb.com.br.sql";


        elseif (file_exists("pv ../../dbs/$storeDb.com.sql"))
            $dump = "pv ../../dbs/$storeDb.com.sql";

//        if (strpos($storeDb, 'bis2bis') !== false || !isset($dump))
//            $dump = file_exists("pv ../../dbs/$storeDb.bis2bis.com.sql")  ? "pv ../../dbs/$storeDb.bis2bis.com.sql" : "pv ../../dbs/$storeDb.bis2bis.com.br.sql";

        if (isset($dump)) {

            shell_exec('mysql -u root -proot -e "create database ' . $storeDb . '";');

            shell_exec("$dump | mysql -u root -proot $storeDb");

            echo shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.admin_user SET password = md5('admin') WHERE email = 'suporte@bis2bis.com.br'\";");
            echo shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 0 WHERE config_id = 669\";");
            echo shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 'http://localhost/$storeDir/' WHERE path = 'web/unsecure/base_url' OR path = 'web/secure/base_url'\";");

            shell_exec('compass compile');

        }else{
            return 'dump error';
        }

    } else {
        return 'cant get the name folder';
    }
} else {
    return 'error editing the local.xml';
}
