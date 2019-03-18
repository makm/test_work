<?php

namespace App\UploadFileProcess;

/**
 * Class AbstractMoveFileProcessor
 * @package App\UploadFileProcess
 */
abstract class AbstractMoveFileProcessor implements MoveFileProcessorInterface
{
    /**
     * @var string
     */
    protected $targetPath;

    /**
     * AbstractMoveFileProcessor constructor.
     * @param string $targetPath
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