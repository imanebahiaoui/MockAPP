<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationControllerTest extends WebTestCase
{
    public function testUserRegistrationSuccess()
    {

        $client = self::createClient();

        $crowler = $client->request('GET', '/register');

        $form = $crowler->selectButton('Register')
                        ->form();

        $rand = md5(uniqid());

        $form['user[login]']                 = 'login_'.$rand;
        $form['user[firstname]']             = 'firstname_'.$rand;
        $form['user[lastname]']              = 'lastname_'.$rand;
        $form['user[plainPassword][first]']  = 'password_'.$rand;
        $form['user[plainPassword][second]'] = 'password_'.$rand;

        $client->submit($form);

        while ($client->getResponse()
                      ->isRedirect()) {
            $crowler = $client->followRedirect();
        }

        $this->assertTrue($client->getResponse()
                                 ->isSuccessful(), sprintf('The %s', $client->getResponse()
                                                                            ->getContent()));

        $this->assertGreaterThan(0,
            $crowler->filter('html:contains("Awesome, your registration was successful, now you can log in")')
                    ->count());
    }
}