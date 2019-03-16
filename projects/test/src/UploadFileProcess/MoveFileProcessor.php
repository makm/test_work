<?php

namespace App\UploadFileProcess;

use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\Traits\DetectFileExtension;

/**
 * Class MoveFileProcessor
 * @package App\UploadFileProcess
 */
class MoveFileProcessor extends AbstractMoveFileProcessor
{
    use DetectFileExtension;

    /**
     * @param $fileSource
     * @return bool
     */
    public function validate($fileSource): bool
    {
        return (strlen($fileSource) < 4096) && file_exists($fileSource);
    }

    /**
     * @param $fileSource
     * @param bool $validate
     * @return string|null
     * @throws \Exception
     */
    public function move($fileSource, $validate = true): ?string
    {
        if (!$this->validate($fileSource)) {
            throw new RuntimeException('File not found, can\'t decode');
        }

        $filename = random_int(111111, 999999);
        $ext = $this->getExtension($fileSource);
        $newFullFilePath = $this->targetPath . $filename . ($ext ? '.' . $ext : '');
        rename($fileSource, $newFullFilePath);
        return $newFullFilePath;
    }
}