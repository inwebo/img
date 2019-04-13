<?php

namespace Inwebo\ImgAPI;

use Inwebo\ImgAPI\Drivers\DriverInterface;
use Inwebo\ImgAPI\Drivers\Factories\FactoryInterface;
use Inwebo\ImgAPI\Drivers\Factories\FileFactory;
use Inwebo\ImgAPI\Drivers\Factories\ResourceFactory;

/**
 * Class Img
 */
class Img
{
    //region attributs
    /** @var DriverInterface */
    protected $driver;
    /** @var Factory[] */
    protected $factories = [];
    /** @var int */
    protected $width = 1;
    /** @var int */
    protected $height = 1;
    /** @var string */
    protected $mimeType = null;
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
    protected function setDriver(DriverInterface $driver): DriverInterface
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return Img
     */
    public function setWidth(int $width): Img
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return Img
     */
    public function setHeight(int $height): Img
    {
        $this->height = $height;

        return $this;
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

    /**
     * AbstractDriver constructor.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width = 1, int $height = 1)
    {
        $this->setWidth($width);
        $this->setHeight($height);
    }

    /**
     * @param int $width
     * @param int $height
     *
     * @return Img
     */
    static public function create(int $width = 1, int $height = 1): Img
    {
        $img = new self($width, $height);
        $img->setDriver(new Drivers\GdDriver(imagecreatetruecolor($width, $height)));
    }

    /**
     * @param mixed $subject
     * @param FactoryInterface[] $factories
     *
     * @return Img
     */
    static public function open($subject, array $factories = [new FileFactory()]): Img
    {

        foreach ($factories as $factory) {
            $driver = $factory->create($subject);

            if(!is_null($driver)) {
                $img = new Img();
                $img
                    ->setDriver($driver)
                    ->setHeight($driver->getHeight())
                    ->setWidth($driver->getWidth())
                    ;

                return $img;
            }
        }
    }


    public function display()
    {
        return $this->getDriver()->display();
    }
}
