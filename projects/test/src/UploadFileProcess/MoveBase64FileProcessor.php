<?php

namespace App\UploadFileProcess;

use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\Traits\DetectFileExtension;

/**
 * Class MoveBase64FileProcessor
 * @package App\UploadFileProcess
 */
class MoveBase64FileProcessor extends AbstractMoveFileProcessor
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
     * @return null|MovedFile
     * @throws \Exception
     */
    public function move($fileSource, $validate = true): ?MovedFile
    {
        if (!$binaryOfFile = \base64_decode($fileSource, true)) {
            throw new RuntimeException('Wrong base64 code, can\'t decode');
        }

        $filename = md5(\random_int(1, 9999999999));
        $fullFilePath = $this->targetPath.$filename;
        file_put_contents($fullFilePath, $binaryOfFile);

        if ($ext = $this->getExtension($fullFilePath)) {
            $filename .= '.'.$ext;
            rename($fullFilePath, $this->targetPath.$filename);
        }

        return new MovedFile($this->targetPath, $filename);
    }
}