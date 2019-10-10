<?php
/**
 * @param $xmlFile
 * @param $tagName
 * @param $value
 *
 * @return string/false
 */
function changeXmlCdataValue($xmlFile, $tagName, $value)
{
    $document = new DOMDocument();
    $document->load($xmlFile);
    $xpath = new DOMXpath($document);

    foreach ($xpath->evaluate("//$tagName/text()") as $linkValue) {
        $linkValue->data = $value;
    }
    return $document->save($xmlFile);
}

function dirFilesList($dir)
{
    $dir = dir($dir);

    $files = [];
    while ($file = $dir->read()) {
        $files[] = $file;
    }
    $dir->close();

    return $files;
}

function findStoreDumpFile($files, $store)
{
    foreach ($files as $file) {
        if(strpos($file, $store) !== false)
            return $file;
    }

    return false;
}

function getDump($storeName = null)
{
    return $storeName . '.com.br.sql';
}

function getShellExec($shell = null)
{
    return explode('\n',json_encode($shell))[1];   
}

function getLabDump($storeName = null)
{
    $dumps = dirFilesList('/home/rodolfo/dev/dbs');
    $file = findStoreDumpFile($dumps, $storeName);
    
    return $file;
}

function makeSqlStoreFile($file){
    shell_exec("mysql -u root -proot -e \"$googleRecaSql\";");
}
/**
 * @return mixed
 */
function getCurrentDir()
{
    $thisDir = explode('/', getcwd());
    return $thisDir[count($thisDir) - 1];
}

/**
 * deveria verificar se é .bis2bis ¯\_(ヅ)_/¯
 *
 * @param $storeDb
 * @return string
 */
function getIsBis2Bis($storeDb)
{
    $palheiro = $storeDb;
    $agulha = 'bis2bis';

    $pos = strpos($palheiro, $agulha);

    if ($pos === false) {
        return false;
    }
    return true;

}
