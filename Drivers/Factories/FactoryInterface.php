<?php

namespace Inwebo\ImgAPI\Drivers\Factories;


use Inwebo\ImgAPI\Drivers\AbstractDriver;

interface FactoryInterface
{
    public function create($subject): ?AbstractDriver;
}