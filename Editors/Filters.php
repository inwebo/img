<?php

namespace Inwebo\ImgAPI\Editors;

/**
 * Class Filters
 *
 * @see https://www.php.net/manual/en/function.imagefilter.php
 */
class Filters
{
    /** @var resource */
    protected $resource;

    // region getters/setters
    /**
     * @return resource
     */
    public function getResource(): resource
    {
        return $this->resource;
    }

    /**
     * @param resource $resource
     *
     * @return Filters
     */
    public function setResource(resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }
    //endregion

    /**
     * Filters constructor.
     *
     * @param resource $resource
     */
    public function __construct(resource $resource)
    {
        $this->setResource($resource);
    }

    /**
     * @return Filters
     */
    public function filterNegate(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_NEGATE);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterGrayscale(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_GRAYSCALE);

        return $this;
    }

    /**
     * @param int $brightness [-255, 255]
     *
     * @return Filters
     */
    public function filterBrightness(int $brightness): self
    {
        imagefilter($this->getResource(), IMG_FILTER_GRAYSCALE, $brightness);

        return $this;
    }

    /**
     * @param int $contrast
     *
     * @return Filters
     */
    public function filterContrast(int $contrast): self
    {
        imagefilter($this->getResource(), IMG_FILTER_CONTRAST, $contrast);

        return $this;
    }

    /**
     * @param int $red [0,255]
     * @param int $green [0,255]
     * @param int $blue [0,255]
     * @param int $alpha [0,255]
     *
     * @return $this
     */
    public function filterColorize(int $red, int $green, int $blue, int $alpha = 1): self
    {
        imagefilter($this->getResource(), IMG_FILTER_GRAYSCALE, $red, $green, $blue, $alpha);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterEdgeDetect(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_EDGEDETECT);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterEmboss(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_EMBOSS);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterGaussianBlur(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_GAUSSIAN_BLUR);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterSelectiveBlur(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_SELECTIVE_BLUR);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterMeanRemoval(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_MEAN_REMOVAL);

        return $this;
    }

    /**
     * @return Filters
     */
    public function filterSmooth(): self
    {
        imagefilter($this->getResource(), IMG_FILTER_SMOOTH);

        return $this;
    }

    /**
     * @param int $pixelSize
     * @param int $effect
     *
     * @todo params
     * @return Filters
     */
    public function filterPixelate(int $pixelSize, int $effect): self
    {
        imagefilter($this->getResource(), IMG_FILTER_PIXELATE, $pixelSize, $effect);

        return $this;
    }


}
