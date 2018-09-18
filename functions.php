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
//    $document->loadXml($document);
    $xpath = new DOMXpath($document);

    foreach ($xpath->evaluate("//$tagName/text()") as $linkValue) {
        $linkValue->data = $value;
    }
    return $document->save($xmlFile);
}

function getDump($storeName = null)
{
    return $storeName. '.com.br.sql';
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