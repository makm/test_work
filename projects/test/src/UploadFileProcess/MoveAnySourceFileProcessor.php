<?php

namespace App\UploadFileProcess;


use App\UploadFileProcess\Exception\RuntimeException;

/**
 * Class MoveImageProcessor
 * @package App\UploadFileProcess
 */
class MoveAnySourceFileProcessor implements MoveFileProcessorInterface
{
    /**
     * @var MoveFileProcessorInterface[]
     */
    private $processors = [];

    /**
     * @param $processors
     * @return MoveAnySourceFileProcessor
     */
    public function setProcessors($processors): MoveAnySourceFileProcessor
    {
        foreach ($processors as $key => $processor) {
            if (!$processor instanceof MoveFileProcessorInterface) {
                throw new RuntimeException('Processor must be implementation of '.MoveFileProcessorInterface::class);
            }
            $this->processors[$key] = $processor;
        }

        return $this;
    }

    /**
     * @param $path
     * @return MoveFileProcessorInterface
     */
    public function setTargetPath($path): MoveFileProcessorInterface
    {
        throw new \RuntimeException('You can\'t use TargetPath directly');
    }

    /**
     * @param $fileSource
     * @return bool
     */
    public function validate($fileSource): bool
    {
        return $this->searchProcessor($fileSource) instanceof MoveFileProcessorInterface;
    }

    /**
     * @param $fileSource
     * @return MoveFileProcessorInterface
     */
    private function searchProcessor($fileSource): ?MoveFileProcessorInterface
    {
        foreach ($this->processors as $processor) {
            if ($processor->validate($fileSource)) {
                return $processor;
            }
        }

        return null;
    }

    /**
     * @param $fileSource
     * @param bool $validate
     * @return null|string
     */
    public function move($fileSource, $validate = true): ?string
    {
        if (!$processor = $this->searchProcessor($fileSource)) {
            throw new RuntimeException('Can\'t detect processor for use');
        }

        return $processor->move($fileSource);
    }
}