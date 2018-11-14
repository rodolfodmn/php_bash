<?php
include '/home/rodolfo/dev/php_bash/functions.php';
$files = dirFilesList('./');
var_dump($files);
$unz =  findStoreDumpFile($files, 'ibyte');
var_dump(substr($unz, 0, strlen($unz)-3));
// shell_exec("gunzip livrariasfamiliacrista*");
// shell_exec("mv livrariasfamiliacrista* livrariasfamiliacrista.com.br.sql");
// echo 'teste maroto!!';
