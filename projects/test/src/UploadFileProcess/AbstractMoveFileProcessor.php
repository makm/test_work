<?php

namespace App\UploadFileProcess;

/**
 * Class AbstractMoveImageProcessor
 * @package App\UploadFileProcess
 */
abstract class AbstractMoveFileProcessor implements MoveFileProcessorInterface
{
    /**
     * @var string
     */
    protected $targetPath;

    /**
     * MoveBase64ImageProcessor constructor.
     * @param $targetPath
     */
    public function __construct(string $targetPath)
    {
        $this->setTargetPath($targetPath);
    }

    /**
     * @param $path
     * @return MoveFileProcessorInterface
     */
    public function setTargetPath($path): MoveFileProcessorInterface
    {
        $this->targetPath = \rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
//        die($this->targetPath);
//        mkdir($this->targetPath, 0777, true);
        return $this;
    }

    /**
     * @return string
     */
    public function getTargetPath(): string
    {
        return $this->targetPath;
    }
}