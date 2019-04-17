<?php

namespace Inwebo\ImgAPI;

use Inwebo\ImgAPI\Drivers\DriverInterface;
use Inwebo\ImgAPI\Drivers\Factories\FactoryInterface;
use Inwebo\ImgAPI\Drivers\Factories\FileFactory;
use Inwebo\ImgAPI\Editors\Filters;
use Inwebo\ImgAPI\Exceptions\AbstractImgException;
use Inwebo\ImgAPI\Exceptions\DriverException;
use Inwebo\ImgAPI\Exceptions\FilterException;

/**
 * Class Img
 */
class Img
{
    //region attributs
    /** @var DriverInterface */
    protected $driver;
    /** @var FactoryInterface[] */
    protected $factories = [];
    /** @var int */
    protected $width = 1;
    /** @var int */
    protected $height = 1;
    /** @var string */
    protected $mimeType = null;
    /** @var Filters */
    protected $filters;
    //endregion

    //region getters/setters
    /**
     * @return DriverInterface
     */
    public function getDriver(): DriverInterface
    {
        return $this->driver;
    }

    /**
     * @param DriverInterface $driver
     *
     * @return $this
     */
    protected function setDriver(DriverInterface $driver): Img
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->getDriver()->getWidth();
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->getDriver()->getHeight();
    }

    /**
     * @return string|null
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return Img
     */
    public function setMimeType(string $mimeType): Img
    {
        $this->mimeType = $mimeType;

        return $this;
    }
    //endregion

    // region filters
    /**
     * @return Img
     */
    public function negate(): Img
    {
        Filters::negate($this->getDriver()->getResource());

        return $this;
    }

    /**
     * @return Img
     */
    public function grayscale(): Img
    {
        Filters::grayscale($this->getDriver()->getResource());

        return $this;
    }

    /**
     * @param int $brightness
     * @return Img
     *
     * @throws FilterException
     */
    public function brightness(int $brightness = 0): Img
    {
        try {
            Filters::brightness($this->getDriver()->getResource(), $brightness);
        } catch (FilterException $e) {
            throw  $e;
        }

        return $this;
    }

    /**
     * @param int $contrast
     * @return Img
     *
     * @throws FilterException
     */
    public function contrast(int $contrast): Img
    {
        try {
            Filters::contrast($this->getDriver()->getResource(), $contrast);
        } catch (FilterException $e) {
            throw  $e;
        }

        return $this;
    }

    /**
     * @param int $red
     * @param int $green
     * @param int $blue
     * @param int $alpha
     *
     * @return Img
     *
     * @throws FilterException
     */
    public function colorize(int $red, int $green, int $blue, int $alpha): Img
    {
        try {
            Filters::colorize($this->getDriver()->getResource(), $red, $green, $blue, $alpha);
        } catch (FilterException $e) {
            throw  $e;
        }

        return $this;
    }

    /**
     * @return Img
     */
    public function edgeDetect(): Img
    {
        Filters::edgeDetect($this->getDriver()->getResource());

        return $this;
    }

    /**
     * @return Img
     */
    public function emboss(): Img
    {
        Filters::emboss($this->getDriver()->getResource());

        return $this;
    }

    /**
     * @param int $repeat
     *
     * @return $this
     */
    public function gaussianBlur(int $repeat = 1)
    {
        Filters::gaussianBlur($this->getDriver()->getResource(), $repeat);

        return $this;
    }

    /**
     * @return Img
     */
    public function selectiveBlur(): Img
    {
        Filters::selectiveBlur($this->getDriver()->getResource());

        return $this;
    }

    /**
     * @return Img
     */
    public function meanRemoval(): Img
    {
        Filters::meanRemoval($this->getDriver()->getResource());

        return $this;
    }

    /**
     * @param int $level
     *
     * @return Img
     */
    public function smooth(int $level): Img
    {
        Filters::smooth($this->getDriver()->getResource(), $level);

        return $this;
    }

    /**
     * @param int $pixelSize
     * @param bool $advanced
     *
     * @return Img
     */
    public function pixelate(int $pixelSize, bool $advanced = true): Img
    {
        Filters::pixelate($this->getDriver()->getResource(), $pixelSize, $advanced);

        return $this;
    }

    /**
     * @return Img
     *
     * @throws AbstractImgException
     */
    public function sepia(): Img
    {
        Filters::sepia($this->getDriver()->getResource());

        return $this;
    }
    // endregion

    /**
     * AbstractDriver constructor.
     */
    private function __construct() {}

    /**
     * @param int $width
     * @param int $height
     *
     * @return Img
     */
    static public function create(int $width = 1, int $height = 1): Img
    {
        $img = new self();
        $img
            ->setDriver(new Drivers\GdDriver(imagecreatetruecolor($width, $height)))
        ;

        return $img;
    }

    /**
     * @param $subject
     * @param string[] $factories Class FQDN class
     *
     * @return Img
     *
     * @throws AbstractImgException
     */
    static public function open($subject, array $factories = [FileFactory::class]): Img
    {
        $img = null;

        foreach ($factories as $factory) {
            /** @var FactoryInterface $factory */
            $factory = new $factory();
            $driver = $factory->create($subject);

            if(!is_null($driver)) {
                $img = new Img();
                $img
                    ->setDriver($driver)
                    ;

                return $img;
            }
        }

        if(is_null($img)) {
            throw new DriverException(sprintf('%s is not a supported file', $subject));
        }

        return $img;
    }

    /**
     * @return mixed
     */
    public function display()
    {
        return $this->getDriver()->display();
    }
}
