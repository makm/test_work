<?php

namespace App\UploadFileProcess\Traits;

/**
 * Trait DetectFileExtension
 * @package App\UploadFileProcess\Traits
 */
trait DetectFileExtension
{
    /**
     * @param $filepath
     * @return mixed
     */
    public function getExtension($filepath)
    {
        $fh = \finfo_open(FILEINFO_EXTENSION);
        $ext = \finfo_file($fh, $filepath);
        \finfo_close($fh);
        return \explode('/', $ext)[0] ?? null;
    }
}