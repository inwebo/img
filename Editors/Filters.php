<?php

namespace Inwebo\ImgAPI\Editors;

use Inwebo\ImgAPI\Exceptions\AbstractImgException;
use Inwebo\ImgAPI\Exceptions\FilterException;

/**
 * Class Filters
 *
 * @see https://www.php.net/manual/en/function.imagefilter.php
 */
class Filters
{
    /**
     * @param resource $resource
     */
    static public function negate($resource): void
    {
        imagefilter($resource, IMG_FILTER_NEGATE);
    }

    /**
     * @param resource $resource
     */
    static public function grayscale($resource): void
    {
        imagefilter($resource, IMG_FILTER_GRAYSCALE);
    }

    /**
     * @param resource $resource
     * @param int      $brightness [-255, 255]
     *
     * @throws FilterException
     */
    static public function brightness($resource, int $brightness): void
    {
        if($brightness > 255 || $brightness < -255) {
            throw new FilterException(sprintf('%s filter interval [-255, 255], input: %s ', 'Brightness', $brightness));
        }

        imagefilter($resource, IMG_FILTER_BRIGHTNESS, $brightness);
    }

    /**
     * @param resource $resource
     * @param int      $contrast -100 = max contrast, 0 = no change, +100 = min contrast
     *
     * @throws FilterException
     */
    static public function contrast($resource, int $contrast): void
    {
        if($contrast > 255 || $contrast < -255) {
            throw new FilterException(sprintf('%s filter interval [-255, 255], input: %s ', 'Contrast', $contrast));
        }

        imagefilter($resource, IMG_FILTER_CONTRAST, $contrast);
    }

    /**
     * @param resource $resource
     * @param int      $red [-255,255]
     * @param int      $green [-255,255]
     * @param int      $blue [-255,255]
     * @param int      $alpha [-255,255]
     *
     * @throws FilterException
     */
    static public function colorize($resource, int $red = 0, int $green = 0, int $blue = 0, int $alpha = 0): void
    {
        foreach (['red' => $red, 'green' => $green, 'blue' => $blue, 'alpha' => $alpha] as $key => $value) {
            if($value < -255 || $value > 255) {
                throw new FilterException(
                    sprintf('%s filter value interval [-255, 255], %s input: %s', 'Colorize', $key, $value)
                );
            }
        }

        imagefilter($resource, IMG_FILTER_COLORIZE, $red, $green, $blue, $alpha);
    }

    /**
     * @param resource $resource
     */
    static public function edgeDetect($resource): void
    {
        imagefilter($resource, IMG_FILTER_EDGEDETECT);
    }

    /**
     * @param resource $resource
     */
    static public function emboss($resource): void
    {
        imagefilter($resource, IMG_FILTER_EMBOSS);
    }

    /**
     * @param resource $resource
     * @param int      $repeat
     */
    static public function gaussianBlur($resource, int $repeat = 1): void
    {
        while($repeat !=0) {
            imagefilter($resource, IMG_FILTER_GAUSSIAN_BLUR);
            --$repeat;
        }
    }

    /**
     * @param int      $repeat
     * @param resource $resource
     */
    static public function selectiveBlur($resource, int $repeat = 1): void
    {
        while($repeat !=0) {
            imagefilter($resource, IMG_FILTER_SELECTIVE_BLUR);
            --$repeat;
        }
    }

    /**
     * @param resource $resource
     */
    static public function meanRemoval($resource): void
    {
        imagefilter($resource, IMG_FILTER_MEAN_REMOVAL);
    }

    /**
     * @param resource $resource
     * @param int      $level level of smoothness
     */
    static public function smooth($resource, int $level): void
    {
        imagefilter($resource, IMG_FILTER_SMOOTH, $level);
    }

    /**
     * @param resource $resource
     * @param int      $pixelSize
     * @param bool     $advanced
     */
    static public function pixelate($resource, int $pixelSize, bool $advanced = true): void
    {
        imagefilter($resource, IMG_FILTER_PIXELATE, $pixelSize, $advanced);
    }

    /**
     * @param resource $resource
     *
     * @throws AbstractImgException
     */
    static public function sepia($resource): void
    {
        Filters::grayscale($resource);
        try {
            Filters::colorize($resource, 90, 60, 30);
        } catch (AbstractImgException $e) {
            throw $e;
        }
    }
}
