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

/**
 * @return mixed
 */
function getCurrentDir()
{
    $thisDir = explode('/', getcwd());
    return $thisDir[count($thisDir) - 1];
}
