<?php

namespace App\UploadFileProcess;

/**
 * Interface UploadFileProcess
 * @package App\UploadFileProcess
 */
interface MoveFileProcessorInterface
{
    public function setTargetPath($path): MoveFileProcessorInterface;

    public function validate($fileSource): bool;

    public function move($fileSource, $validate = true): ?string;
}