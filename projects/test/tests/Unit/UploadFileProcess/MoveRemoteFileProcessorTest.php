<?php

namespace App\Tests\Unit\UploadFileProcess;

use App\UploadFileProcess\MoveRemoteFileProcessor;
use PHPUnit\Framework\TestCase;

class MoveRemoteFileProcessorTest extends TestCase
{
    /**
     * @var MoveRemoteFileProcessor
     */
    private $object;

    public function setUp()
    {
        $this->object = new MoveRemoteFileProcessor('/tmp');
    }

    public function testValidateTrue()
    {
        $this->assertTrue($this->object->validate('http://www.yandex.ru/best.pic.jpg'));
        $this->assertTrue($this->object->validate(
            'https://upload.wikimedia.org/wikipedia/commons/thumb/4/4c/Tom_Clancy_at_Burns_Library%2C_Boston_College.jpg/260px-Tom_Clancy_at_Burns_Library%2C_Boston_College.jpg'
        ));
    }

    public function testValidateFalse()
    {
        $this->assertFalse($this->object->validate('/tmp/noexist.jpg'));
    }

    /**
     * @codeCoverageIgnore
     */
    public function testMove()
    {
//        $this->markTestIncomplete(
//            'This test has not been implemented yet.'
//        );
    }
}
