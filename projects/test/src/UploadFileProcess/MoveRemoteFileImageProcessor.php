<?php

namespace App\UploadFileProcess;

use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\Traits\DetectFileExtension;

/**
 * Class MoveRemoteFileImageProcessor
 * @package App\UploadFileProcess
 */
class MoveRemoteFileImageProcessor extends AbstractMoveFileProcessor
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
     * @return string|null
     * @throws \Exception
     */
    public function move($fileSource, $validate = true): ?string
    {
        if (!$this->validate($fileSource)) {
            throw new RuntimeException('Incorrect remove url, can\'t upload');
        }

        try {
            $filename = md5(\random_int(1, 9999999999));
            $fullFilePath = $this->targetPath.$filename;
            $binaryOfFile = fopen($fileSource, 'r');
            file_put_contents($fullFilePath, $binaryOfFile);

            if ($ext = $this->getExtension($fullFilePath)) {
                $newFullFilePath = $this->targetPath.$filename.'.'.$ext;
                rename($fullFilePath, $newFullFilePath);
                $fullFilePath = $newFullFilePath;
            }
        } catch (\Exception $exception) {
            throw new RuntimeException($exception->getMessage(), $exception->getCode(), $exception);
        }

        return $fullFilePath;
    }
}