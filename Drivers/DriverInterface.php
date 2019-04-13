<?php

namespace Inwebo\ImgAPI\Drivers;

/**
 * Class DiverInterface
 */
interface DriverInterface
{
    public function display();

    public function getWidth(): int;

    public function getHeight(): int;

    public function getResource(): resource;
}
