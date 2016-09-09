<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testUserLoginSuccess()
    {
        $client  = self::createClient();
        $crawler = $client->request('GET', '/login');
        $form    = $crawler->selectButton('Login')
                           ->form();

        $form['login_form[_username]'] = 'yoeunes';
        $form['login_form[_password]'] = 'ensa1234';

        $client->submit($form);

        while ($client->getResponse()
                      ->isRedirect()) {
            $crawler = $client->followRedirect();
        }

        $this->assertTrue($client->getResponse()
                                 ->isSuccessful(), sprintf('The %s', $client->getResponse()
                                                                            ->getContent()));

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Logout")')
                                            ->count());
    }
}