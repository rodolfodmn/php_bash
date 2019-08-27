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

echo 'php script é o caminho!' . PHP_EOL;
echo 'instalando module..' . PHP_EOL;

$ref = $argv[2];
$module  = $argv[1];
$modulesDir = (isset($argv[3]) && isset($argv[3]) === true) ? "/home/rodolfo/dev/modulos-dev/modulo-" : "/home/rodolfo/dev/modulos/modulo-" ;
$moduleDirFull = $modulesDir.$module;
$dirsModuleArr = ['app', 'js', 'skin', 'lib'];
$storeDir = (getCurrentDir()) ? getCurrentDir() : false;
$moduleDir = (dirFilesList($moduleDirFull)) ? dirFilesList($moduleDirFull) : false;

foreach ($moduleDir as $key => $dir) {
    if (in_array($dir, $dirsModuleArr)) {
        shell_exec("cp -r $moduleDirFull/$dir/* ./$dir/");
    }
}