<?php

namespace Symfony\Cmf\Bundle\SimpleCmsBundle\Tests\WebTest\TestApp;

use Symfony\Cmf\Component\Testing\Functional\BaseTestCase;

class HttpStatusCodeTest extends BaseTestCase
{
    public function setUp()
    {
        $this->db('PHPCR')->loadFixtures(array(
            'Symfony\Cmf\Bundle\SimpleCmsBundle\Tests\Resources\DataFixtures\Phpcr\LoadPageData',
        ));
        $this->client = $this->createClient();
    }

    public function provideStatusCodeTest()
    {
        return array(
            array('/', 301),
            array('/en/homepage'),
            array('/en/french-page'),
            array('/no-locale-prefix'),
        );
    }

    /**
     * @dataProvider provideStatusCodeTest
     */
    public function testStatusCode($url, $expectedStatusCode = 200)
    {
        $crawler = $this->client->request('GET', $url);
        $res = $this->client->getResponse();
        $this->assertEquals($expectedStatusCode, $res->getStatusCode());
    }
}
