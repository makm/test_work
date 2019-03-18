<?php

namespace App\UploadFileProcess;

/**
 * Class MovedFile
 * @package App\Tests\Unit\UploadFileProcess
 */
class MovedFile
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * MovedFile constructor.
     * @param $path
     * @param $name
     */
    public function __construct($path, $name)
    {
        $this->setPath($path);
        $this->setName($name);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return MovedFile
     */
    public function setPath(string $path): MovedFile
    {
        $this->path = rtrim($path,'/').DIRECTORY_SEPARATOR;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return MovedFile
     */
    public function setName(string $name): MovedFile
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullPath(): string
    {
        return $this->path.$this->name;
    }
}