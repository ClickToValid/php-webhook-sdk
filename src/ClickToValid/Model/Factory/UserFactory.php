<?php

namespace ClickToValid\Model\Factory;

use ClickToValid\Model\User;

class UserFactory
{
    /**
     * @param \stdClass $data
     *
     * @return User
     */
    public static function parseData(\stdClass $data)
    {
        $user = new User();

        if (property_exists($data, 'id')) {
            $user->setId($data->id);
        }

        if (property_exists($data, 'username')) {
            $user->setUsername($data->username);
        }

        if (property_exists($data, 'email')) {
            $user->setEmail($data->email);
        }

        if (property_exists($data, 'firstname')) {
            $user->setFirstname($data->firstname);
        }

        if (property_exists($data, 'lastname')) {
            $user->setLastname($data->lastname);
        }

        return $user;
    }
}
