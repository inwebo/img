<?php

namespace Inwebo\ImgAPI\Editors;

use Inwebo\ImgAPI\Drivers\AbstractDriver;
use Inwebo\ImgAPI\Img;

/**
 * Class Edit
 */
class Edit
{
    const FLIP_HORIZONTAL = 1;
    const FLIP_VERTICAL = 2;
    const FLIP_BOTH = 3;

    /** @var AbstractDriver */
    protected $driver;

    /**
     * @return AbstractDriver
     */
    public function getDriver(): AbstractDriver
    {
        return $this->driver;
    }

    /**
     * @param AbstractDriver $driver
     */
    public function setDriver(AbstractDriver $driver)
    {
        $this->driver = $driver;
    }

    /**
     * Edit constructor.
     *
     * @param AbstractDriver $driver
     */
    public function __construct(AbstractDriver &$driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param int $new_width  Default 1
     * @param int $new_height Default 1
     *
     * @return Edit
     */
    public function resize(int $new_width = 1, int $new_height = 1): self
    {
        // Resize fixed width and height
        if (isset($new_width) && isset($new_height)) {
            $width   = $new_width;
            $height = $new_height;
        } // Resize by new width
        elseif (is_null($new_height) && isset($new_width)) {
            // Ratio by width
            if ($new_width > $img->getWidth()) {
                $ratio  = $new_width / $img->getWidth();
                $width  = $new_width;
                $height = round($img->getHeight() * $ratio);
            } else {
                $ratio  = $img->getWidth() / $new_width;
                $width  = $new_width;
                $height = round($img->getHeight() / $ratio);
            }
        } // Resize by new height
        elseif (isset($new_height) && is_null($new_width)) {
            // Ratio by height
            if ($new_height > $img->getHeight()) {
                $ratio = $new_height / $img->getHeight();
                $width = round($img->getWidth() * $ratio);
                $height = $new_height;
            } else {
                $ratio = $img->getHeight() / $new_height;
                $width = round($img->getWidth() / $ratio);
                $height = $new_height;
            }
        }

        $image_mini = imagecreatetruecolor($width, $height);
        $colorTransparent = imagecolortransparent($this->getDriver()->getResource());
        imagepalettecopy($image_mini, $this->getDriver()->getResource());
        imagefill($image_mini, 0, 0, $colorTransparent);
        imagecolortransparent($image_mini, $colorTransparent);

        imagecopyresized($image_mini, $this->getDriver()->getResource(), 0, 0, 0, 0, $width, $height, $img->getWidth(), $img->getHeight());

        return $this;
    }

    /**
     * @param Img $img
     *
     * @return Edit
     */
    public function mask(Img $img): self
    {
        return $this;
    }

    /**
     * @param Img $img
     *
     * @return Edit
     */
    public function pattern(Img $img): self
    {
        return $this;
    }

    /**
     * @return Edit
     */
    public function crop(): self
    {
        return $this;
    }

    /**
     * @param Img  $img
     * @param bool $fastProcessing
     *
     * @return Edit
     */
    public function merge(Img $img, bool $fastProcessing): self
    {
        return $this;
    }

    /**
     * @param int $mode
     *
     * @return Edit
     */
    public function flip(int $mode = self::FLIP_BOTH): self
    {
        return $this;
    }
}
