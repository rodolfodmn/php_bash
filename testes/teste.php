<?php
include '/home/rodolfo/dev/php_bash/functions.php';
$str = 'http://localhost/shop-dos-cristais/media/catalog/product/6/0/601643-pingente-ametista-lapidado.jpg';

$img_link = $str;
$link_img_fix = str_replace(
    'https://www.shopdoscristais.com.br',
    'http: //localhost/shop-dos-cristais',
    $img_link
);

echo $link_img_fix;
