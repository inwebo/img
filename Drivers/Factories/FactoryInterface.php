<?php
/**
 * Created by PhpStorm.
 * User: julien
 * Date: 09/04/19
 * Time: 12:27
 */

namespace Inwebo\ImgAPI\Drivers\Factories;


use Inwebo\ImgAPI\Drivers\AbstractDriver;

interface FactoryInterface
{
    public function create($subject): ?AbstractDriver;
}