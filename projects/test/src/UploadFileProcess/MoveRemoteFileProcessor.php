<?php

namespace App\UploadFileProcess;

use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\Traits\DetectFileExtension;

/**
 * Class MoveRemoteFileProcessor
 * @package App\UploadFileProcess
 */
class MoveRemoteFileProcessor extends AbstractMoveFileProcessor
{
    use DetectFileExtension;

    /**
     * @param $fileSource
     * @return bool
     */
    public function validate($fileSource): bool
    {
        return filter_var(trim($fileSource), FILTER_VALIDATE_URL);
    }

    /**
     * @param $fileSource
     * @param bool $validate
     * @return MovedFile|null
     */
    public function move($fileSource, $validate = true): ?MovedFile
    {
        if (!$this->validate($fileSource)) {
            throw new RuntimeException('Incorrect remove url, can\'t upload');
        }

        try {
            $filename = md5(\random_int(1, 9999999999));
            $fullFilePath = $this->targetPath.$filename;
            $binaryOfFile = fopen($fileSource, 'rb');
            file_put_contents($fullFilePath, $binaryOfFile);

            if ($ext = $this->getExtension($fullFilePath)) {
                $filename.='.'.$ext;
                rename($fullFilePath, $this->targetPath.$filename);
            }
        } catch (\Exception $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return new MovedFile($this->targetPath, $filename);
    }
}