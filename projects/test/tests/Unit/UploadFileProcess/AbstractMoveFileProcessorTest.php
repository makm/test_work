<?php

namespace App\Tests\Unit\UploadFileProcess;

use App\UploadFileProcess\AbstractMoveFileProcessor;
use App\UploadFileProcess\MovedFile;
use PHPUnit\Framework\TestCase;

class AbstractMoveImageProcessorTest extends TestCase
{

    public function testSetGetTargetPath()
    {
        $object = new MoveProcessorTestClass('/nothing');
        $object->setTargetPath('/some/bad/path///');
        $this->assertEquals('/some/bad/path/', $object->getTargetPath());
    }
}

class MoveProcessorTestClass extends AbstractMoveFileProcessor
{
    public function validate($fileSource): bool
    {
        return false;
    }

    public function move($fileSource, $validate = true): ?MovedFile
    {
        return null;
    }
}