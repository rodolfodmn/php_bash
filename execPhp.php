<?php
try {

    $proxy = new SoapClient('http://localhost/mk-import/api/v2_soap/?wsdl');

    $sessionId = $proxy->login((object) array('username' => 'admin', 'apiKey' => 'admin12'));

    $result = $proxy->salesOrderAddComment((object) array('sessionId' => $sessionId->result, 'orderIncrementId' => '100000305', 'status' => 'pudim', 'state' => 'arroz'));
    var_dump($result->result);
} catch (Exception $e) {

    echo $e->getMessage();

}
