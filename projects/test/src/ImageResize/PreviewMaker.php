<?php

namespace App\ImageResize;

use Gumlet\ImageResize;

/**
 * Class PreviewMaker
 * @package App\ImageResize
 */
class PreviewMaker
{
    /**
     * @param $filename
     * @param $w
     * @param $h
     * @return string
     */
    private function createFilePreviewName($filename, $w, $h): string
    {
        $parts = pathinfo($filename);

        return $parts['dirname']
            . DIRECTORY_SEPARATOR
            . "{$parts['filename']}_{$w}x{$h}.{$parts['extension']}";
    }

    /**
     * @param $filename
     */
    private function createFilePreviewUrl($filename)
    {

    }

    /**
     * @param $filename
     * @param $w
     * @param $h
     * @return string
     * @throws \Gumlet\ImageResizeException
     */
    public function make($filename, $w, $h): string
    {
        $imageResize = new ImageResize($filename);
        $previewName = $this->createFilePreviewName($filename, $w, $h);
        $imageResize->resize($w, $h);
        $imageResize->save($previewName);
        return $previewName;
    }
}