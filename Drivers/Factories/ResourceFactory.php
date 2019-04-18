<?php

namespace Inwebo\ImgAPI\Drivers\Factories;

use Inwebo\ImgAPI\Drivers\AbstractDriver;
use Inwebo\ImgAPI\Drivers\GdDriver;

/**
 * Class ResourceFactory
 */
class ResourceFactory implements FactoryInterface
{
    /**
     * @param mixed $subject
     *
     * @return AbstractDriver|null
     */
    public function create($subject): ?AbstractDriver
    {
        if(is_resource($subject)) {
            $driver = new GdDriver($subject);

            return $driver;
        }

        return null;
    }
}