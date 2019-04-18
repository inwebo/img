<?php

namespace Inwebo\ImgAPI\Editors;

/**
 * Class Edit
 */
class Edit
{
    const FLIP_HORIZONTAL = 1;
    const FLIP_VERTICAL   = 2;
    const FLIP_BOTH       = 3;

    /**
     * @param resource $resource
     * @param int      $width
     * @param int      $height
     *
     * @return resource
     */
    static public function resize($resource, ?int $width = null, ?int $height = null)
    {
        $computedWidth  = null;
        $computedHeight = null;

        // Resize fixed width and height
        if (isset($width) && isset($height)) {
            $computedWidth  = $width;
            $computedHeight = $height;
        } // Resize by new width
        elseif (is_null($height) && isset($width)) {
            // Ratio by width
            if ($width > imagesx($resource)) {
                $ratio          = $width / imagesx($resource);
                $computedWidth  = $width;
                $computedHeight = round(imagesy($resource) * $ratio);
            } else {
                $ratio          = imagesx($resource) / $width;
                $computedWidth  = $width;
                $computedHeight = round(imagesy($resource) / $ratio);
            }
        } // Resize by new height
        elseif (isset($height) && is_null($width)) {
            // Ratio by height
            if ($height > imagesy($resource)) {
                $ratio          = $height / imagesy($resource);
                $computedWidth  = round(imagesx($resource) * $ratio);
                $computedHeight = $height;
            } else {
                $ratio          = imagesy($resource) / $height;
                $computedWidth  = round(imagesx($resource) / $ratio);
                $computedHeight = $height;
            }
        }

        $thumb            = imagecreatetruecolor($computedWidth, $computedHeight);
        $colorTransparent = imagecolortransparent($resource);
        imagepalettecopy($thumb, $resource);
        imagefill($thumb, 0, 0, $colorTransparent);
        imagecolortransparent($thumb, $colorTransparent);

        imagecopyresized($thumb, $resource, 0, 0, 0, 0, $computedWidth, $computedHeight, imagesx($resource), imagesy($resource));

        return $thumb;
    }

    /**
     * @param $resource
     *
     * @return array
     */
    static public function getPalette($resource): array
    {

        $result        = [];
        $subjectWidth  = imagesx($resource);
        $subjectHeight = imagesy($resource);

        for ($x = 0; $x < $subjectWidth; $x++) {
            for ($y = 0; $y < $subjectHeight; $y++) {
                $result[] = imagecolorsforindex($resource, imagecolorat($resource, $x, $y));
            }
        }

        return  $result;
    }

    /**
     * @param resource $resource
     * @param int $mode IMG_FLIP_HORIZONTAL|IMG_FLIP_VERTICAL|IMG_FLIP_BOTH
     *
     * @see http://php.net/manual/en/function.imageflip.php
     */
    static public function flip( $resource, $mode = IMG_FLIP_VERTICAL ){
        imageflip($resource, $mode);
    }
}
