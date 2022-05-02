<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginFunctionalTest extends WebTestCase
{
    public function testShouldDisplayLoginPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        
        $this->assertSelectorTextContains('h3', 'GeTon - Login');
        $this->assertSelectorTextContains('label', 'Email');
    }

    public function testLoginpageWithBadCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Login')->form([
            'email' => 'test@test.com',
            'password' => 'wrong_password',
        ]);
        
        $client->submit($form);
        
        $this->assertResponseRedirects('/login', 302);

        $crawler = $client->followRedirect();

        $this->assertSame(1, $crawler->filter('html:contains("Invalid credentials")')->count());
    }

    public function testLoginWithGoodCredentialsRedirectsToHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Login')->form([
            'email' => 'zleconte@noos.fr',
            'password' => 'password',
        ]);

        $client->submit($form);

        $this->assertResponseRedirects('', 302);
        //$crawler = $client->followRedirect();
        //dd($crawler);
        //$this->assertSame(1, $crawler->filter('html:contains("Attendu prochaine rencontre")')->count());
    }
}
