<?php

/**
 * @author    Julien Hannotin <julien@ddf.agency>
 *
 * @copyright 2019 Digital Dealer Factory
 *
 * @license   All rights reserved
 *
 * Date: 09/04/19
 * Time: 12:28
 *
 */

namespace Inwebo\ImgAPI\Drivers\Factories;

use Inwebo\ImgAPI\Drivers\AbstractDriver;
use Inwebo\ImgAPI\Drivers\GdDriver;

/**
 * Class FileFactory
 */
class FileFactory implements FactoryInterface
{

    /**
     * @param mixed $subject
     *
     * @return AbstractDriver|null
     */
    public function create($subject): ?AbstractDriver
    {
        $content = file_get_contents($subject);

        if(is_resource($content)) {
            $driver     = new GdDriver(imagecreatefromstring($content));
            $imageInfos = getimagesizefromstring($content);

            if(false !== $imageInfos) {
                $driver
                    ->setMimeType($imageInfos['mime']);
            }

            return $driver;
        }
    }
}
