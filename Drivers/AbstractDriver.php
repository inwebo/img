<?php

namespace Inwebo\ImgAPI\Drivers;

/**
 * Class AbstractDriver
 */
abstract class AbstractDriver implements DriverInterface
{
    //region attributs
    /** @var resource */
    protected $resource;
    /** @var string */
    protected $mimeType;
    /** @var null|string */
    protected $subject = null;
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

    /**
     * @return null|string
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return AbstractDriver
     */
    public function setSubject(string $subject): AbstractDriver
    {
        $this->subject = $subject;

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
     * @return string builtin gd function name
     */
    private function getGdFunctionName(): string
    {
        $mimeTypeToPhpFunction = explode('/', $this->getMimeType());

        $subject      = strtolower($mimeTypeToPhpFunction[1]);
        $functionName = sprintf('image%s', $subject);

        return $functionName;
    }

    protected function getBinary(): void
    {
        $functionName = $this->getGdFunctionName();
        if(function_exists($functionName)) {
            $functionName($this->getResource());
        }
    }

    public function display()
    {
        header(sprintf('Content-Type: %s', $this->getMimeType()));
        imagealphablending($this->getResource(), false);
        imagesavealpha($this->getResource(), true);

        $this->getBinary();

        exit;
    }

    /**
     * @param string $path
     *
     * @param mixed ...$arg
     */
    public function save(string $path, ...$arg)
    {
        $functionName = $this->getGdFunctionName();
        if(function_exists($functionName)) {
            $functionName($this->getResource(), $path);
        }
    }
}
