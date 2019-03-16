<?php

namespace App\UploadFileProcess;

use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\Traits\DetectFileExtension;

/**
 * Class MoveBase64ImageProcessor
 * @package App\UploadFileProcess
 */
class MoveBase64ImageProcessor extends AbstractMoveFileProcessor
{
    use DetectFileExtension;

    /**
     * @param $fileSource
     * @return bool
     */
    public function validate($fileSource): bool
    {
        return (bool)base64_decode($fileSource, true);
    }

    /**
     * @param $fileSource
     * @param bool $validate
     * @return string|null
     * @throws \Exception
     */
    public function move($fileSource, $validate = true): ?string
    {
        if (!$binaryOfFile = \base64_decode($fileSource, true)) {
            throw new RuntimeException('Wrong base64 code, can\'t decode');
        }

        $filename = md5(\random_int(1, 9999999999));
        $fullFilePath = $this->targetPath . $filename;
        file_put_contents($fullFilePath, $binaryOfFile);

        if ($ext = $this->getExtension($fullFilePath)) {
            $newFullFilePath = $this->targetPath . $filename . '.' . $ext;
            rename($fullFilePath, $newFullFilePath);
            $fullFilePath = $newFullFilePath;
        }

        return $fullFilePath;
    }
}