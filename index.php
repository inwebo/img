<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use  Inwebo\ImgAPI\Img as Img;

include_once 'autoload.php';

//$src = './tests/subject-jpeg.jpg';
$src = './tests/transparent.png';
//$src = './tests/subject-bmp.bmp';
//$src = './tests/test.bmp';
//$src = './tests/subject-ico.ico';
//$src = 'http://static.php.net/www.php.net/images/php.gif';
//$src = 'https://www.icone-png.com/png/27/27181.png';
try {
    $img = Img::open($src);
    $img
//        ->negate()
//        ->grayScale()
//        ->brightness()
//        ->colorize(0, 0, 255, 0)
//        ->gaussianBlur(10)
//        ->emboss()
//        ->edgeDetect()
//        ->emboss()
//        ->selectiveBlur(100)
//        ->smooth(100)
//        ->pixelate(10)
        ->resize(128, 128)
//        ->save("tests/export.png")
        ->display()
    ;
//    var_dump($img->getExifData());
//    var_dump($img->resize(128, 128)->getPalette());
    ;

} catch (\Exception $e) {
    echo $e->getMessage();
}