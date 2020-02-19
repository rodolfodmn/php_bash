<?php

/**
 * Store Install Main
 *
 * Esse script tem como objetive automatizar a instalalção das lojas
 * Atualmente esse script consegue instalar somente lojas com dumps com nomeDaLoja.com.br.sql
 * para instalar lojas que não seguem essa configuração, favor utilizar o storeBasicInstall.php
 *
 */

include 'functions.php';
include 'Model/ApiUser.php';

echo 'php script é o caminho!' . PHP_EOL;

shell_exec('cp ../../hta/local.xml ./app/etc/');
shell_exec('cp ../../hta/htaccess ./.htaccess');

shell_exec('mkdir var/');
//// shell_exec('chmod 777 var/ -R');

$pv = 'pv ~/dev/dbs/';
// $pv = 'pv /var/www/html/';
$labSql = 'sql_para_lojas_gitlab.sql';
$host = '192.168.1.105:8080';
$setPass = changeXmlCdataValue('app/etc/local.xml', 'password', 'root');
$dontOpen = ($argv[1]) ? $argv[1] : false ;

if ($setPass) {
	$storeDir = (getCurrentDir()) ? getCurrentDir() : false;
	$storeDb = ($storeDir) ? str_replace('-', '', $storeDir) : false;

	$setDB = changeXmlCdataValue('app/etc/local.xml', 'dbname', $storeDb);

	if ($storeDir && $storeDb) {

		$dump = getDump($storeDb);

		if (isset($dump)) {

			$httpsSql = "UPDATE $storeDb.checkout_config_data SET https = 2 WHERE (oschttpsurl LIKE '%https%' OR oscloginhttpsurl LIKE '%https%' OR text_term LIKE '%https%' OR version LIKE '%https%') AND id = 1";
			$googleRecaSql = "UPDATE $storeDb.core_config_data SET value = 0 WHERE path LIKE '%active%' AND path LIKE '%googlerecaptcha%'";

			shell_exec('mysql -u root -proot -e "create database ' . $storeDb . '";');
			shell_exec("$pv$dump | mysql -u root -proot $storeDb");

			shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.admin_user SET password = md5('admin') WHERE username = 'admin'\";");
			shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 0 WHERE config_id = 669\";");
			shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 'http://$host/$storeDir/' WHERE path = 'web/unsecure/base_url' OR path = 'web/secure/base_url'\";");
			shell_exec("mysql -u root -proot -e \"use $storeDb; DROP TRIGGER IF EXISTS upd_stock\";");
			shell_exec("$pv$labSql | mysql -u root -proot $storeDb");
			shell_exec("mysql -u root -proot -e \"$httpsSql\";");
			shell_exec("mysql -u root -proot -e \"$googleRecaSql\";");

			new ApiUser($storeDb);
			if(!$dontOpen){
				shell_exec("google-chrome http://localhost/$storeDir/");
				shell_exec("google-chrome http://localhost/$storeDir/admin");
			}

			shell_exec('compass compile');
		} else {
			return 'dump error';
		}

	} else {
		return 'cant get the name folder';
	}
} else {
	return 'error editing the local.xml';
}
