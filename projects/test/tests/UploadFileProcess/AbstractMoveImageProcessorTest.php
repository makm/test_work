<?php

namespace App\UploadFileProcess;

use PHPUnit\Framework\TestCase;

class AbstractMoveImageProcessorTest extends TestCase
{

    public function testSetGetTargetPath()
    {
        $object = new RealClass('/nothing');
        $object->setTargetPath('/some/bad/path///');
        $this->assertEquals('/some/bad/path/', $object->getTargetPath());
    }
}

class RealClass extends AbstractMoveFileProcessor
{
    public function validate($fileSource): bool
    {
        return false;
    }

    public function move($fileSource, $validate = true): ?string
    {
        return null;
    }
}