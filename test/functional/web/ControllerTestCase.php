<?php

/*
 * This file is part of the TempoSimple project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TempoSimple\Test\Functional\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ControllerTestCase extends WebTestCase
{
    protected $client;

    protected function browsing($method, $route)
    {
        $this->client = static::createClient();

        $this->client->request($method, $route);
    }

    protected function whenAskingTheActivityReport()
    {
        $this->browsing('GET', 'activity');
    }

    protected function thenItShouldSuceed()
    {
        $response = $this->client->getResponse();

        $this->assertSame(Response::HTTP_OK, $response->getStatusCode());
    }
}
