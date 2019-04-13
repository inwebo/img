<?php

namespace Inwebo\ImgAPI\Factories;

use Inwebo\ImgAPI\Img;

class Factory
{
    /** @var Img */
    protected $img;

    /**
     * @return Img
     */
    public function getImg(): Img
    {
        return $this->img;
    }

    /**
     * @param Img $img
     */
    protected function setImg(Img $img): void
    {
        $this->img = $img;
    }

    /**
     * Factory constructor.
     * @param Img $img
     */
    public function __construct(Img $img)
    {
        $this->img = $img;
    }


    /**
     * @param mixed $subject
     * @return bool
     */
    public function support(mixed $subject)
    {
        return is_null($subject);
    }

    /**
     * @return resource
     */
    public function create(): resource
    {
        $resource = imagecreatetruecolor($this->getImg()->getWidth(), $this->getImg()->getHeight());
        $color    = imagecolorallocate($resource, 0, 0, 0);
        imagecolortransparent($resource, $color);

        return $resource;
    }
}