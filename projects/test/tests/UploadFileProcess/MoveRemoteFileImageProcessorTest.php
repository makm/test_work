<?php

namespace App\UploadFileProcess;


use PHPUnit\Framework\TestCase;

class MoveRemoteFileImageProcessorTest extends TestCase
{
    /**
     * @var MoveRemoteFileImageProcessor
     */
    private $object;

    public function setUp()
    {
        $this->object = new MoveRemoteFileImageProcessor('/tmp');
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
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }
}
