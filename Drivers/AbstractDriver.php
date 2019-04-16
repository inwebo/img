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
        return imagesx($this->resource);
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return imagesy($this->resource);
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param resource $resource
     */
    protected function setResource($resource)
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
    public function __construct(&$resource)
    {
        if(is_resource($resource)) {
            $this->resource = $resource;
        }
    }

    /**
     * @return mixed
     */
    protected function getBinary()
    {
        $mimeTypeToPhpFunction = explode('/', $this->getMimeType());

        $subject      = strtolower($mimeTypeToPhpFunction[1]);
        $functionName = sprintf('image%s', $subject);

        if(function_exists($functionName)) {

            $binary = $functionName($this->getResource());

            if(false !== $binary) {
                return $binary;
            }
        }
    }

    public function display()
    {
        header(sprintf('Content-Type: %s', $this->getMimeType()));
        $this->getBinary();
        exit;
    }
}
