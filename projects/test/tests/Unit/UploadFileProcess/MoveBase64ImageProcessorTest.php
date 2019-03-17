<?php

namespace App\Tests\Unit\UploadFileProcess;

use App\UploadFileProcess\Exception\RuntimeException;
use App\UploadFileProcess\MoveBase64ImageProcessor;
use PHPUnit\Framework\TestCase;

/**
 * Class MoveBase64ImageProcessorTest
 * @package App\UploadFileProcess
 */
class MoveBase64ImageProcessorTest extends TestCase
{
    /**
     * @var MoveBase64ImageProcessor
     */
    private $object;

    /**
     * @var string
     */
    private $fileTestPath = __DIR__.'/resource/testfile.jpg';


    public function setUp()
    {
        $this->object = new MoveBase64ImageProcessor('/tmp');
    }

    public function testValidateTrue()
    {
        $b64code = base64_encode(file_get_contents($this->fileTestPath));
        $this->assertTrue($this->object->validate($b64code));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function validateFalseDataProvider(): array
    {
        return [
            [
                strrev(
                    base64_encode(file_get_contents($this->fileTestPath))
                )
            ],
            [
                'http://blacktimemachine.com/' . random_int(9999999999, 1111111111111) . 'jpg'
            ],
        ];
    }

    /**
     * @param $string
     * @dataProvider validateFalseDataProvider
     */
    public function testValidateFalse($string)
    {
        $this->assertFalse($this->object->validate($string));
    }

    /**
     * @throws \Exception
     */
    public function testMove()
    {
        $md5file = md5_file($this->fileTestPath);
        $b64code = base64_encode(file_get_contents($this->fileTestPath));
        $filename = $this->object->move($b64code);

        $this->assertFileExists($filename);
        $this->assertEquals($md5file, md5_file($filename));
        $this->assertEquals('jpeg', pathinfo($filename, PATHINFO_EXTENSION));
        unlink($filename);
    }

    public function testMoveFail()
    {
        $this->expectException(RuntimeException::class);
        $fileCode = strrev(
            base64_encode(file_get_contents($this->fileTestPath))
        );
        $this->object->move($fileCode);
    }
}
