<?php

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

        if(is_string($content)) {
            $img       = @imagecreatefromstring($content);
            if(false === $img) {
                return null;
            }
            $driver    = new GdDriver($img);
            $imageType = @exif_imagetype($subject);

            if(false !== $imageType) {
                $mimeType = @image_type_to_mime_type($imageType);
                if(false !== $mimeType) {
                    $driver
                        ->setMimeType($mimeType)
                    ;
                }
            }

            return $driver;
        }

        return null;
    }
}
