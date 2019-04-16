<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use  Inwebo\ImgAPI\Img as Img;

include_once 'autoload.php';

//$src = './tests/logo.jpg';
//$src = './tests/test.bmp';
$src = 'http://static.php.net/www.php.net/images/php.gif';

try {
    $img = Img::open($src);
    $img->display();
} catch (\Exception $e) {
    echo $e->getMessage();
}