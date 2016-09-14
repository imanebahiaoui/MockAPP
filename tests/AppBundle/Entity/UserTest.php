<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /** @var  ValidatorInterface */
    private $validator;

    /** @var  User */
    private $user;

    const ATTR_LOGIN = 'login';
    const ATTR_PASSWORD = 'password';

    const LOGIN_MIN_LENGTH = 3;
    const PASSWORD_MIN_LENGTH = 6;


    protected function setUp()
    {
        $this->validator = Validation::createValidatorBuilder()
                                     ->enableAnnotationMapping()
                                     ->getValidator();
        $this->user      = new User();
    }


    public function testLoginIsRequired()
    {
        $errors = $this->validator->validateProperty($this->user, self::ATTR_LOGIN);
        $this->assertTrue(count($errors) > 0);

        $this->user->setLogin('yoeunes');
        $errors = $this->validator->validateProperty($this->user, self::ATTR_LOGIN);
        $this->assertEquals(0, count($errors));
    }


    public function testLoginLengthShouldBeGreaterThanMinLength()
    {
        $this->user->setLogin('yo');
        $errors = $this->validator->validateProperty($this->user, self::ATTR_LOGIN);
        $this->assertTrue(strlen($this->user->getUsername()) < self::LOGIN_MIN_LENGTH);
        $this->assertTrue(count($errors) > 0);

        $this->user->setLogin('user');
        $errors = $this->validator->validateProperty($this->user, self::ATTR_LOGIN);
        $this->assertTrue(strlen($this->user->getUsername()) >= self::LOGIN_MIN_LENGTH);
        $this->assertEquals(0, count($errors));
    }


    public function testPasswordLengthShouldBeGreaterThanMinLength()
    {
        $this->user->setPassword('***');
        $errors = $this->validator->validateProperty($this->user, self::ATTR_PASSWORD);
        $this->assertTrue(strlen($this->user->getPassword()) < self::PASSWORD_MIN_LENGTH);
        $this->assertTrue(count($errors) > 0);

        $this->user->setPassword('******');
        $errors = $this->validator->validateProperty($this->user, self::ATTR_PASSWORD);
        $this->assertTrue(strlen($this->user->getPassword()) >= self::PASSWORD_MIN_LENGTH);
        $this->assertEquals(0, count($errors));
    }

}