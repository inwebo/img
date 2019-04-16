<?php

namespace Inwebo\ImgAPI;

use Inwebo\ImgAPI\Drivers\DriverInterface;
use Inwebo\ImgAPI\Drivers\Factories\FactoryInterface;
use Inwebo\ImgAPI\Drivers\Factories\FileFactory;

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
     * @throws \Exception
     */
    static public function open($subject, array $factories = [FileFactory::class]): Img
    {
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
    }

    /**
     * @return mixed
     */
    public function display()
    {
        return $this->getDriver()->display();
    }
}
