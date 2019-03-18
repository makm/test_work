<?php

namespace App\Tests\Unit\UploadFileProcess;


use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\MoveFileProcessor;
use PHPUnit\Framework\TestCase;

class MoveFileMoveProcessorTest extends TestCase
{
    /**
     * @var string
     */
    private $uploadedFile = '/tmp/uploaded.jpeg';

    /**
     * @var string
     */
    private $fileTestPath = __DIR__.'/resource/testfile.jpg';

    /**
     * @var MoveFileProcessor
     */
    private $object;

    public function setUp()
    {
        $this->object = new MoveFileProcessor('/tmp');
        copy($this->fileTestPath, $this->uploadedFile);
    }

    public function testValidateTrue()
    {
        $this->assertTrue($this->object->validate($this->uploadedFile));
    }

    public function testValidateFalse()
    {
        $this->assertFalse($this->object->validate('/tmp/noexist.jpg'));
    }

    public function testValidateFalseWithOutException()
    {
        $sourceMustBeCodeB64 = strrev(
            base64_encode(file_get_contents($this->fileTestPath))
            . base64_encode(file_get_contents($this->fileTestPath))
            . base64_encode(file_get_contents($this->fileTestPath))
            . base64_encode(file_get_contents($this->fileTestPath))

        );

        $this->assertGreaterThan(4096, strlen($sourceMustBeCodeB64));
        $this->assertFalse($this->object->validate($sourceMustBeCodeB64));
    }

    /**
     * @throws \Exception
     */
    public function testMoveSuccess()
    {
        $this->assertFileExists($this->uploadedFile);
        $filename = $this->object->move($this->uploadedFile);
        $this->assertFileExists($filename->getFullPath());
        $this->assertFileNotExists($this->uploadedFile);
    }

    public function testMoveFail()
    {
        $this->expectException(RuntimeException::class);
        $file = '/tmp/false-not-found1';
        $this->assertFileNotExists($file);
        $this->object->move($file);
    }
}
