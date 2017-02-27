<?php

namespace ClickToValid\Tests\Model\Factory;

use ClickToValid\Model\Factory\UserFactory;
use ClickToValid\Model\User;

class UserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data = json_decode(json_encode([
            'id'        => '8233f750-8281-41d0-bf55-3a0bb9e661ce',
            'username'  => 'JohnDoe',
            'email'     => 'johndoe@mycompany.com',
            'firstname' => 'John',
            'lastname'  => 'Doe',
        ]));
        $user = UserFactory::parseData($data);

        // Tests a User is returned
        $this->assertInstanceOf(User::class, $user);

        // Tests User fields are well hydrated
        $this->assertEquals('8233f750-8281-41d0-bf55-3a0bb9e661ce', $user->getId());
        $this->assertEquals('JohnDoe', $user->getUsername());
        $this->assertEquals('johndoe@mycompany.com', $user->getEmail());
        $this->assertEquals('John', $user->getFirstname());
        $this->assertEquals('Doe', $user->getLastname());
    }
}
