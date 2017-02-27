<?php

namespace ClickToValid\Tests\Model\Factory;

use ClickToValid\Model\Factory\FileFactory;
use ClickToValid\Model\File;

class FileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data = json_decode(json_encode([
            'id'        => '8233f750-8281-41d0-bf55-3a0bb9e661ce',
            'filename'  => 'my-file.jpg',
            'size'      => 565,
            'extension' => 'jpg',
            'mimetype'  => 'image/jpeg',
        ]));
        $file = FileFactory::parseData($data);

        // Tests a File is returned
        $this->assertInstanceOf(File::class, $file);

        // Tests File fields are well hydrated
        $this->assertEquals('8233f750-8281-41d0-bf55-3a0bb9e661ce', $file->getId());
        $this->assertEquals('my-file.jpg', $file->getFilename());
        $this->assertEquals(565, $file->getSize());
        $this->assertEquals('jpg', $file->getExtension());
        $this->assertEquals('image/jpeg', $file->getMimetype());
    }
}
