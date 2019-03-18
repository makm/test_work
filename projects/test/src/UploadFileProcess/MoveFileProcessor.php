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
     * @return MovedFile|null
     * @throws \Exception
     */
    public function move($fileSource, $validate = true): ?MovedFile
    {
        if (!$this->validate($fileSource)) {
            throw new RuntimeException('File not found, can\'t decode');
        }

        $filename = random_int(111111, 999999);
        $ext = $this->getExtension($fileSource);
        $fileName = $filename.($ext ? '.'.$ext : '');
        rename($fileSource, $this->targetPath.$fileName);

        return new MovedFile($this->targetPath, $fileName);
    }
}