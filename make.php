<?php
try {
    /**
     * php -d phar.readonly=0 make.php
     */
    @unlink('./phar/img.phar');
    $phar = new Phar('./img.phar');
//    $phar->setDefaultStub('index.php');
    $phar->buildFromDirectory('./', '/^.+\..+$/');
} catch (Exception $e) {
    echo $e->getMessage();
}