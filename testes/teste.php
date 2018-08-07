<?php
function changeXmlCdataValue($xmlFile, $tagName, $value)
{
    $document = new DOMDocument();
    $document->load($xmlFile);
//    $document->loadXml($document);
    $xpath = new DOMXpath($document);

    foreach ($xpath->evaluate("//$tagName/text()") as $linkValue) {
        $linkValue->data = $value;
    }
    return $document->save($xmlFile);
}

/**
 * @return mixed
 */
function getCurrentDir()
{
    $thisDir = explode('/', getcwd());
    return $thisDir[count($thisDir) - 1];
}

//shell_exec('cp ../hta/local.xml ./app/etc/');
//shell_exec('cp ../hta/htaccess ./.htaccess');
//
//shell_exec('mkdir var/');
// shell_exec('chmod 777 var/ -R');

changeXmlCdataValue('data.xml', 'password', 'root');

//if ($setPass) {
//
//    $storeDir = (getCurrentDir()) ? getCurrentDir() : false;
//    $storeDb = ($storeDir) ? str_replace('-', '', $storeDir) : false;
//
//    if ($storeDir && $storeDb) {
//        shell_exec('mysql -u root -proot -e "create database ' . $storeDb . '";');
//
//        shell_exec("pv ../../dbs/$storeDb.com.br.sql | mysql -u root -proot $storeDb");
//
//        shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.admin_user SET password = md5('admin') WHERE email = 'suporte@bis2bis.com.br'\";");
//        shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 0 WHERE config_id = 669\";");
//        shell_exec("mysql -u root -proot -e \"UPDATE $storeDb.core_config_data SET value = 'http://localhost/lojas/$storeDir/' WHERE path = 'web/unsecure/base_url' AND 'web/secure/base_url'\";");
//
//        shell_exec('compass compile');
//    } else {
//        return 'cant get the name folder';
//    }
//} else {
//    return 'error editing the local.xml';
//}