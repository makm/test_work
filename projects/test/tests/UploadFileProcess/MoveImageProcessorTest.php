<?php

namespace App\Tests\UploadFileProcess;


use App\UploadFileProcess\MoveAnySourceFileProcessor;
use App\UploadFileProcess\MoveFileProcessorInterface;
use PHPUnit\Framework\TestCase;

class MoveImageProcessorTest extends TestCase
{
    public function testValidate()
    {
        $processor1 = $this->createMock(MoveFileProcessorInterface::class);
        $processor1->expects($this->once())
            ->method('validate')
            ->willReturn(false);

        $processor2 = $this->createMock(MoveFileProcessorInterface::class);
        $processor2->expects($this->once())
            ->method('validate')
            ->willReturn(true);

        $processor3 = $this->createMock(MoveFileProcessorInterface::class);
        $processor3->expects($this->never())
            ->method('validate')
            ->willReturn(false);


        $testObject = new MoveAnySourceFileProcessor();

        $testObject->setProcessors([
            $processor1,
            $processor2,
            $processor3,
        ]);
        $string = 'somefilesourse';
        $result = $testObject->validate($string);
        $this->assertEquals(true, $result);
    }

    /**
     * @codeCoverageIgnore
     */
    public function testMove()
    {
        // incorrect  processor
        $file = '/filename.jpg';
        $processor1 = $this->createMock(MoveFileProcessorInterface::class);
        $processor1->expects($this->once())
            ->method('validate')
            ->willReturn(false);

        $processor1->expects($this->never())
            ->method('move');

        // incorrect  processor
        $processor2 = $this->createMock(MoveFileProcessorInterface::class);
        $processor2->expects($this->once())
            ->method('validate')
            ->willReturn(false);
        $processor2->expects($this->never())
            ->method('move');

        // valid  processor
        $processor3 = $this->createMock(MoveFileProcessorInterface::class);
        $processor3->expects($this->once())
            ->method('validate')
            ->willReturn(true);
        $processor3->expects($this->once())
            ->method('move')
            ->willReturn($file);


        $testObject = new MoveAnySourceFileProcessor();

        $testObject->setProcessors([
            $processor1,
            $processor2,
            $processor3,
        ]);
        $string = 'somefilesourse';
        $result = $testObject->move($string);
        $this->assertEquals($file, $result);
    }
}
