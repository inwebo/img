<?php

namespace Inwebo\ImgAPI\Drivers;

/**
 * Class AbstractDriver
 */
class AbstractDriver implements DriverInterface
{
    //region attributs
    /** @var resource */
    protected $resource;
    /** @var string */
    protected $mimeType;
    //endregion



    //region getters/setters
    /**
     * @return int
     */
    public function getHeight(): int
    {
        imagesx($this->resource);
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        imagesy($this->resource);
    }

    /**
     * @return resource
     */
    public function getResource(): resource
    {
        return $this->resource;
    }

    /**
     * @param resource $resource
     */
    protected function setResource(resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     *
     * @return AbstractDriver
     */
    public function setMimeType(string $mimeType): AbstractDriver
    {
        $this->mimeType = $mimeType;

        return $this;
    }
    //endregion

    /**
     * AbstractDriver constructor.
     *
     * @param resource $resource
     */
    public function __construct(resource &$resource)
    {
        $this->resource = $resource;
    }

    public function display()
    {
        header(sprintf('Content-Type: %s', $this->getMimeType()));
        imagejpeg($this->getResource());
        exit;
    }
}
