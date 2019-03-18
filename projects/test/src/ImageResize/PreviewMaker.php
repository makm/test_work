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

        return "{$parts['filename']}_{$w}x{$h}.{$parts['extension']}";
    }

    /**
     * @param $path
     * @param $filename
     * @param $w
     * @param $h
     * @return string
     * @throws \Gumlet\ImageResizeException
     */
    public function make($path, $filename, $w, $h): string
    {
        $imageResize = new ImageResize($path.$filename);
        $previewName = $this->createFilePreviewName($filename, $w, $h);
        $imageResize->resize($w, $h);
        $imageResize->save($path.$previewName);

        return $previewName;
    }
}