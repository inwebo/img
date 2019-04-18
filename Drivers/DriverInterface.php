<?php

namespace Inwebo\ImgAPI\Drivers;

/**
 * Class DiverInterface
 */
interface DriverInterface
{
    public function display();

    public function getWidth(): int;

    public function getHeight(): int;

    public function getSubject(): ?string;

    public function setSubject(string $subject);

    public function setMimeType(string $string);

    public function getMimeType(): string;

    public function getResource();
}
